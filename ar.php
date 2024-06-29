<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location: user_login.php");
    exit();
}

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
            background-color: black;
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
            background-color: transparent;
            border: 4px solid gray;
            border-radius: 10px;
            color: gray;
            font-weight: bold;
            cursor: pointer;
        }
        #backButton:hover {
            border: 4px solid white;
            color: white;
            opacity: 0.6;
        }
    </style>

    <!-- Include SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <button id="backButton">BACK</button>

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
        let modelLoaded = false;
        let model;

        let raycaster, touchPosition, pointerDown = false, pointerPrevious = { x: 0, y: 0 };

        init();
        animate();

        function init() {
            let myCanvas = document.getElementById("canvas");

            // Check if user is on a desktop
            if (!isMobileDevice()) {
                Swal.fire({
                    icon: 'info',
                    title: 'Looks like you\'re using the desktop device.',
                    text: 'Open the web app on any mobile device to use the AR experience.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'product_details.php?product_id=<?php echo $product_id; ?>';
            });
            }

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

            raycaster = new THREE.Raycaster();
            touchPosition = new THREE.Vector2();

            window.addEventListener('touchstart', onTouchStart, { passive: false });
            window.addEventListener('touchmove', onTouchMove, { passive: false });
            window.addEventListener('touchend', onTouchEnd, false);
        }

        function onSelect() {
            if (reticle.visible && !modelLoaded) {
                modelLoaded = true;

                const loader = new GLTFLoader();
                loader.load(modelPath, function (glb) {
                    model = glb.scene;
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

        function onTouchStart(event) {
            if (model && event.touches.length === 1) {
                touchPosition.x = (event.touches[0].clientX / window.innerWidth) * 2 - 1;
                touchPosition.y = - (event.touches[0].clientY / window.innerHeight) * 2 + 1;

                raycaster.setFromCamera(touchPosition, camera);

                const intersects = raycaster.intersectObject(model, true);

                if (intersects.length > 0) {
                    pointerDown = true;
                    pointerPrevious.x = event.touches[0].clientX;
                    pointerPrevious.y = event.touches[0].clientY;
                }
            }
        }

        function onTouchMove(event) {
            if (pointerDown && model && event.touches.length === 1) {
                let deltaMove = {
                    x: event.touches[0].clientX - pointerPrevious.x,
                    y: event.touches[0].clientY - pointerPrevious.y
                };

                let deltaRotationQuaternion = new THREE.Quaternion()
                    .setFromEuler(new THREE.Euler(
                        toRadians(deltaMove.y * 1),
                        toRadians(deltaMove.x * 1),
                        0,
                        'XYZ'
                    ));

                model.quaternion.multiplyQuaternions(deltaRotationQuaternion, model.quaternion);

                pointerPrevious.x = event.touches[0].clientX;
                pointerPrevious.y = event.touches[0].clientY;
            }
        }

        function onTouchEnd(event) {
            pointerDown = false;
        }

        function toRadians(angle) {
            return angle * (Math.PI / 180);
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

        // Function to detect if the user is on a mobile device
        function isMobileDevice() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
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
