<?php
include ('dbcon.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$model_name = $_GET['file_path'];

$sql = "SELECT * FROM products WHERE file_path = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $model_name);
$stmt->execute();
$stmt->bind_result($file_path);
$stmt->fetch();
$stmt->close();
$conn->close();

$file_path_json = json_encode(['file_path' => $file_path]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Home</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        #ar-view {
            width: 100vw;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div id="ar-view"></div>
    <script src="https://cdn.jsdelivr.net/npm/three@0.127.0/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.127.0/examples/js/loaders/GLTFLoader.js"></script>
    <script>
        const modelData = <?php echo $file_path_json; ?>;
        if (!modelData.file_path) {
            alert('Model not found');
            throw new Error('Model not found');
        }

        const modelPath = modelData.file_path;
        initAR(modelPath);

        function initAR(modelPath) {
            let container;
            let camera, scene, renderer;
            let controller;
            let reticle;
            let hitTestSource = null;
            let hitTestSourceRequested = false;

            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(70, window.innerWidth / window.innerHeight, 0.01, 20);
            
            renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            renderer.setPixelRatio(window.devicePixelRatio);
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.xr.enabled = true;
            document.getElementById('ar-view').appendChild(renderer.domElement);
            
            const light = new THREE.HemisphereLight(0xffffff, 0xbbbbff, 1);
            scene.add(light);
            
            const geometry = new THREE.RingGeometry(0.15, 0.2, 32).rotateX(- Math.PI / 2);
            const material = new THREE.MeshBasicMaterial();
            reticle = new THREE.Mesh(geometry, material);
            reticle.matrixAutoUpdate = false;
            reticle.visible = false;
            scene.add(reticle);
            
            const loader = new THREE.GLTFLoader();
            loader.load(modelPath, (gltf) => {
                model = gltf.scene;
                model.visible = false;
                scene.add(model);
            }, undefined, (error) => {
                console.error(error);
            });

            // Setup XR session
            navigator.xr.requestSession('immersive-ar', { requiredFeatures: ['hit-test'] })
                .then((session) => {
                    renderer.xr.setReferenceSpaceType('local');
                    renderer.xr.setSession(session);

                    // Setup controller for hit-testing
                    controller = renderer.xr.getController(0);
                    controller.addEventListener('select', onSelect);
                    scene.add(controller);
                    
                    // Start animation loop
                    renderer.setAnimationLoop(render);
                });
        }

        function onSelect() {
            if (reticle.visible && model) {
                model.position.setFromMatrixPosition(reticle.matrix);
                model.visible = true;
            }
        }

        function render(timestamp, frame) {
            if (frame) {
                const referenceSpace = renderer.xr.getReferenceSpace();
                const session = renderer.xr.getSession();

                if (!hitTestSourceRequested) {
                    session.requestReferenceSpace('viewer').then((referenceSpace) => {
                        session.requestHitTestSource({ space: referenceSpace }).then((source) => {
                            hitTestSource = source;
                        });
                    });

                    session.addEventListener('end', () => {
                        hitTestSourceRequested = false;
                        hitTestSource = null;
                    });

                    hitTestSourceRequested = true;
                }

                if (hitTestSource) {
                    const hitTestResults = frame.getHitTestResults(hitTestSource);

                    if (hitTestResults.length) {
                        const hit = hitTestResults[0];

                        const referenceSpace = renderer.xr.getReferenceSpace();
                        const pose = hit.getPose(referenceSpace);

                        reticle.visible = true;
                        reticle.matrix.fromArray(pose.transform.matrix);
                    } else {
                        reticle.visible = false;
                    }
                }
            }

            renderer.render(scene, camera);
        }
    </script>
</body>
</html>
