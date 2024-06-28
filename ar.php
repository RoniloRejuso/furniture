<?php
session_start();
include 'dbcon.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $sql = "SELECT file_path FROM products WHERE product_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $model_path = $row['file_path'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-*********************" crossorigin="anonymous" />
    <title>Our Home</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #canvas {
            width: 100vw;
            height: 100vh;
        }
        #backButton {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 10px;
            opacity: 0.5;
            background-color: #964B33;
            border-radius: 5px;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        #backButton:hover {
            background-color: #964B33;
        }
        
    </style>
</head>
<body>
    <button id="backButton">Back</button>

    <canvas id="canvas"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/three@0.127.0/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.127.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.127.0/examples/jsm/webxr/ARButton.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.127.0/examples/jsm/webxr/XREstimatedLight.js"></script>

    <script type="module">
        import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.127.0/build/three.module.js';
        import { ARButton } from './ARButton.js';
        import { GLTFLoader } from 'https://cdn.jsdelivr.net/npm/three@0.127.0/examples/jsm/loaders/GLTFLoader.js';
        import { XREstimatedLight } from 'https://cdn.jsdelivr.net/npm/three@0.127.0/examples/jsm/webxr/XREstimatedLight.js';

        let reticle;
        let hitTestSource = null;
        let hitTestSourceRequested = false;
        let scene, camera, renderer;
        let modelPath = "<?php echo $model_path; ?>";
        let modelScaleFactor = 0.01;
        let controller;
        let modelLoaded = false; // Track if the model is loaded

        init();
        animate();

        function init() {
            let myCanvas = document.getElementById("canvas");

            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(
                70,
                window.innerWidth / window.innerHeight,
                0.01,
                20
            );

            const light = new THREE.HemisphereLight(0xffffff, 0xbbbbff, 1);
            light.position.set(0.5, 1, 0.25);
            scene.add(light);

            renderer = new THREE.WebGLRenderer({
                canvas: myCanvas,
                antialias: true,
                alpha: true,
            });
            renderer.setPixelRatio(window.devicePixelRatio);
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.xr.enabled = true;

            const xrLight = new XREstimatedLight(renderer);
            xrLight.addEventListener("estimationstart", () => {
                scene.add(xrLight);
                scene.remove(light);
                if (xrLight.environment) {
                    scene.environment = xrLight.environment;
                }
            });

            xrLight.addEventListener("estimationend", () => {
                scene.add(light);
                scene.remove(xrLight);
            });

            let arButton = ARButton.createButton(renderer, {
                requiredFeatures: ["hit-test"],
                optionalFeatures: ["dom-overlay", "light-estimation"],
                domOverlay: { root: document.body },
            });
            arButton.style.bottom = "20px";
            document.body.appendChild(arButton);

            controller = renderer.xr.getController(0);
            controller.addEventListener("select", onSelect);
            scene.add(controller);

            const geometry = new THREE.RingGeometry(0.15, 0.2, 32).rotateX(-Math.PI / 2);
            const material = new THREE.MeshBasicMaterial();
            reticle = new THREE.Mesh(geometry, material);
            reticle.matrixAutoUpdate = false;
            reticle.visible = false;
            scene.add(reticle);
        }

        function onSelect() {
            if (reticle.visible && !modelLoaded) { // Ensure model is not already loaded
                modelLoaded = true; // Set flag to true once model is loaded to prevent re-loading

                const loader = new GLTFLoader();
                loader.load(modelPath, function (glb) {
                    let model = glb.scene;
                    model.position.setFromMatrixPosition(reticle.matrix);
                    model.scale.set(modelScaleFactor, modelScaleFactor, modelScaleFactor);
                    scene.add(model);
                    console.log(`Model added to scene`);
                }, undefined, function (error) {
                    console.error(`Error loading model:`, error);
                });
            } else {
                console.log("Reticle not visible or model already loaded, cannot place model");
            }
        }

        function animate() {
            renderer.setAnimationLoop(render);
        }

        function render(timestamp, frame) {
            if (frame) {
                const referenceSpace = renderer.xr.getReferenceSpace();
                const session = renderer.xr.getSession();
                if (!hitTestSourceRequested) {
                    session.requestReferenceSpace("viewer").then((referenceSpace) => {
                        session.requestHitTestSource({ space: referenceSpace }).then((source) => {
                            hitTestSource = source;
                        });
                    });
                    session.addEventListener("end", () => {
                        hitTestSourceRequested = false;
                        hitTestSource = null;
                    });
                    hitTestSourceRequested = true;
                }

                if (hitTestSource) {
                    const hitTestResults = frame.getHitTestResults(hitTestSource);
                    if (hitTestResults.length) {
                        const hit = hitTestResults[0];
                        reticle.visible = true;
                        reticle.matrix.fromArray(hit.getPose(referenceSpace).transform.matrix);
                        console.log("Hit test successful, reticle visible");
                    } else {
                        reticle.visible = false;
                        console.log("Hit test failed, reticle not visible");
                    }
                }
            }
            renderer.render(scene, camera);
        }
        document.getElementById('backButton').addEventListener('click', function() {
        window.history.back();
    });
    </script>
</body>
</html>
<?php
    } else {
        echo "No model found for the specified product_id.";
        exit;
    }
} else {
    echo "Product ID is missing.";
    exit;
}
?>
