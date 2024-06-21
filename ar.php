<?php
session_start();
include ('dbcon.php');
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location:login.php");
    exit();
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$model_name = $_GET['file_path'] ?? '';

$sql = "SELECT file_path FROM products WHERE file_path = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Failed to prepare statement: " . $conn->error);
}

$stmt->bind_param("s", $model_name);
$stmt->execute();
$stmt->bind_result($file_path);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Test</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        #ar-view {
            width: 100vw;
            height: 100vh;
            display: none;
        }
        #start-ar-button {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            font-size: 16px;
            background-color: transparent;
            color: grey;
            border: 5px solid grey;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }
        #capture-button {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px;
            font-size: 30px;
            background-color: transparent;
            color: grey;
            border: 5px solid grey;
            border-radius: 100%;
            cursor: pointer;
            font-weight: bold;
            display: none;
        }
    </style>
</head>
<body>
    <div id="ar-view"></div>
    <button id="start-ar-button">Start AR</button>
    <button id="capture-button"><i class="fas fa-camera"></i></button>

    <script src="https://cdn.jsdelivr.net/npm/three@0.127.0/build/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.127.0/examples/js/loaders/GLTFLoader.js"></script>
    <script>
        const modelPath = <?php echo json_encode($file_path); ?>;

        document.addEventListener('DOMContentLoaded', () => {
            let startARButton = document.getElementById('start-ar-button');
            let captureButton = document.getElementById('capture-button');
            let model;
            let renderer, scene, camera, reticle;

            startARButton.addEventListener('click', () => {
                startARButton.style.display = 'none';
                captureButton.style.display = 'block';
                document.getElementById('ar-view').style.display = 'block';
                initAR(modelPath);
            });

            captureButton.addEventListener('click', captureImage);

            let initialTouchX, initialTouchY;
            const rotationSpeed = 0.005;

            function initAR(modelPath) {
                if (!navigator.xr) {
                    alert('WebXR not supported');
                    return;
                }

                navigator.xr.isSessionSupported('immersive-ar').then((supported) => {
                    if (supported) {
                        navigator.xr.requestSession('immersive-ar', { requiredFeatures: ['hit-test'] })
                            .then(onSessionStarted)
                            .catch((error) => {
                                console.error('Error starting AR session:', error);
                            });
                    } else {
                        alert('Immersive AR not supported');
                    }
                }).catch((error) => {
                    console.error('Error checking XR support:', error);
                });
            }

            function onSessionStarted(session) {
                session.addEventListener('end', onSessionEnded);

                renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
                renderer.setPixelRatio(window.devicePixelRatio);
                renderer.setSize(window.innerWidth, window.innerHeight);
                renderer.xr.enabled = true;
                document.getElementById('ar-view').appendChild(renderer.domElement);

                scene = new THREE.Scene();
                camera = new THREE.PerspectiveCamera(70, window.innerWidth / window.innerHeight, 0.01, 20);

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

                session.addEventListener('select', onSelect);

                session.updateRenderState({ baseLayer: new XRWebGLLayer(session, renderer) });

                session.requestReferenceSpace('local-floor').then((referenceSpace) => {
                    session.requestAnimationFrame((time, frame) => {
                        render(frame, session, camera, scene, renderer, referenceSpace);
                    });
                }).catch((error) => {
                    console.error('Error requesting reference space:', error);
                });
            }

            function onSessionEnded() {
                // Handle session end
            }

            function onSelect(event) {
                const session = event.target.session;
                if (reticle.visible && model) {
                    model.position.setFromMatrixPosition(reticle.matrix);
                    model.visible = true;
                }
            }

            function render(frame, session, camera, scene, renderer, referenceSpace) {
                session.requestAnimationFrame((time, frame) => {
                    render(frame, session, camera, scene, renderer, referenceSpace);
                });

                const xrViewerPose = frame.getViewerPose(referenceSpace);
                if (xrViewerPose) {
                    const viewMatrix = xrViewerPose.views[0].transform.inverse.matrix;
                    const viewProjectionMatrix = xrViewerPose.views[0].projectionMatrix;

                    camera.projectionMatrix.fromArray(viewProjectionMatrix);
                    camera.matrix.fromArray(viewMatrix).getInverse(camera.matrix);
                    camera.updateMatrixWorld(true);

                    const hitTestResults = frame.getHitTestResults(session.hitTestSource);
                    if (hitTestResults.length > 0) {
                        const pose = hitTestResults[0].getPose(referenceSpace);
                        reticle.visible = true;
                        reticle.matrix.fromArray(pose.transform.matrix);
                    } else {
                        reticle.visible = false;
                    }

                    renderer.render(scene, camera);
                }
            }

            function captureImage() {
                if (!model) {
                    console.error('Model not loaded');
                    return;
                }

                const canvas = document.createElement('canvas');
                const width = window.innerWidth;
                const height = window.innerHeight;
                canvas.width = width;
                canvas.height = height;

                const context = canvas.getContext('2d');
                renderer.render(scene, camera);
                context.drawImage(renderer.domElement, 0, 0, width, height);

                canvas.toBlob((blob) => {
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'ar_image.png';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                }, 'image/png');
            }

            function onTouchStart(event) {
                if (event.touches.length === 1) {
                    initialTouchX = event.touches[0].pageX;
                    initialTouchY = event.touches[0].pageY;
                }
            }

            function onTouchMove(event) {
                if (event.touches.length === 1 && model) {
                    const deltaX = event.touches[0].pageX - initialTouchX;
                    const deltaY = event.touches[0].pageY - initialTouchY;
                    model.rotation.y += deltaX * rotationSpeed;
                    model.rotation.x += deltaY * rotationSpeed;
                    initialTouchX = event.touches[0].pageX;
                    initialTouchY = event.touches[0].pageY;
                }
            }

            window.addEventListener('touchstart', onTouchStart, false);
            window.addEventListener('touchmove', onTouchMove, false);
        });
    </script>
</body>
</html>
