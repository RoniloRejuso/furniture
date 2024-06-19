<?php
<<<<<<< HEAD
include ('dbcon.php');

=======
<<<<<<< HEAD
include ('dbcon.php');

=======
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "furniture";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
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
<<<<<<< HEAD
=======
=======
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$furniture = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $furniture[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();

header('Content-Type: application/json');
echo json_encode($furniture);
?>

<!DOCTYPE html>
<html>
<head>
    <title>AR Furniture</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://unpkg.com/aframe-ar@1.7.0/dist/aframe-ar.min.js"></script>
    <script src="https://unpkg.com/aframe-extras@6.1.0/dist/aframe-extras.min.js"></script>
    <script>
        async function fetchFurniture() {
            const response = await fetch('get_furniture.php');
            const furniture = await response.json();
            loadFurniture(furniture);
        }

        function loadFurniture(furniture) {
            const scene = document.querySelector('a-scene');

            furniture.forEach(item => {
                const entity = document.createElement('a-entity');
                entity.setAttribute('gltf-model', item.model_url);
                entity.setAttribute('position', '0 0 -2');
                entity.setAttribute('scale', '0.5 0.5 0.5');
                entity.setAttribute('rotation', '0 0 0');
                entity.setAttribute('gesture-handler', '');

                scene.appendChild(entity);
            });
        }

        document.addEventListener('DOMContentLoaded', fetchFurniture);
    </script>
    <style>
        body, html {
            margin: 0;
            overflow: hidden;
            width: 100%;
            height: 100%;
        }
        a-scene {
            width: 100%;
            height: 100%;
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
        }
    </style>
</head>
<body>
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
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
<<<<<<< HEAD
=======
=======
    <a-scene embedded arjs='sourceType: webcam;'>
        <a-marker preset='hiro'>
            <a-entity gltf-model="#model" scale="0.5 0.5 0.5" position="0 0 0" gesture-handler></a-entity>
        </a-marker>
        <a-entity camera></a-entity>
    </a-scene>

    <script>
        // Gesture handler component to rotate the model
        AFRAME.registerComponent('gesture-handler', {
            schema: {
                enabled: {default: true}
            },
            init: function () {
                this.handleRotation = this.handleRotation.bind(this);
                this.el.addEventListener('mousedown', this.handleRotation);
                this.el.addEventListener('mousemove', this.handleRotation);
                this.el.addEventListener('mouseup', this.handleRotation);
                this.el.addEventListener('touchstart', this.handleRotation);
                this.el.addEventListener('touchmove', this.handleRotation);
                this.el.addEventListener('touchend', this.handleRotation);
            },
            remove: function () {
                this.el.removeEventListener('mousedown', this.handleRotation);
                this.el.removeEventListener('mousemove', this.handleRotation);
                this.el.removeEventListener('mouseup', this.handleRotation);
                this.el.removeEventListener('touchstart', this.handleRotation);
                this.el.removeEventListener('touchmove', this.handleRotation);
                this.el.removeEventListener('touchend', this.handleRotation);
            },
            handleRotation: function (evt) {
                if (evt.type === 'mousedown' || evt.type === 'touchstart') {
                    this.isMouseDown = true;
                    this.startX = evt.type === 'mousedown' ? evt.screenX : evt.touches[0].screenX;
                    this.startRotationY = this.el.object3D.rotation.y;
                } else if ((evt.type === 'mousemove' && this.isMouseDown) || (evt.type === 'touchmove' && this.isMouseDown)) {
                    const currentX = evt.type === 'mousemove' ? evt.screenX : evt.touches[0].screenX;
                    const deltaX = currentX - this.startX;
                    const rotationY = this.startRotationY + deltaX * 0.01;
                    this.el.object3D.rotation.y = rotationY;
                } else if (evt.type === 'mouseup' || evt.type === 'touchend') {
                    this.isMouseDown = false;
                }
            }
        });
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
    </script>
</body>
</html>
