<?php
include ('dbcon.php');

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

$file_path_json = json_encode(['file_path' => $file_path]);

if(isset($_POST['add_to_cart'])){

    $product_name = $_POST['product_name'];
    $price = $_POST['price']; 
    $product_quantity = 1;
    $product_image = $_POST['product_image'];

    $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE product_name = '$product_name'");

    if(mysqli_num_rows($select_cart) > 0){
        $message[] = 'Product already added to cart';
    }else{
        $insert_product = mysqli_query($conn, "INSERT INTO `cart`(product_name, price, quantity, product_image) VALUES('$product_name', '$price', '$product_quantity', '$product_image')");
        
        if($insert_product){
            $message = 'Product added to cart successfully';
        } else {
            $message = 'Failed to add product to cart';
        }
    }
    header("Location: user_carts.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-*********************" crossorigin="anonymous" />
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
            background-color:transparent;
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
            background-color:transparent;
            color: grey;
            border: 5px solid grey;
            border-radius: 100%;
            cursor: pointer;
            font-weight: bold;
        }
        #capture-button {
            bottom: 70px;
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
        const modelPath = 'path/to/your/model.gltf'; // Replace this with the actual path to your model file

        let startARButton = document.getElementById('start-ar-button');
        let captureButton = document.getElementById('capture-button');
        let model;
        let initialTouchX = 0;
        let initialTouchY = 0;
        let rotationSpeed = 0.005;
        let renderer, scene, camera, reticle;

        startARButton.addEventListener('click', () => {
            startARButton.style.display = 'none';
            captureButton.style.display = 'block';
            document.getElementById('ar-view').style.display = 'block';
            initAR(modelPath);
        });

        captureButton.addEventListener('click', captureImage);

        function initAR(modelPath) {
            if (!navigator.xr) {
                alert('WebXR not supported');
                return;
            }

            navigator.xr.isSessionSupported('inline').then((supported) => {
                if (supported) {
                    navigator.xr.requestSession('inline', { requiredFeatures: ['hit-test'] })
                        .then(onSessionStarted)
                        .catch((error) => {
                            console.error('Error starting AR session:', error);
                        });
                } else {
                    alert('Inline AR not supported');
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
            session.addEventListener('end', onSessionEnded);

            session.updateRenderState({ baseLayer: new XRWebGLLayer(session, renderer) });

            session.requestReferenceSpace('viewer').then((referenceSpace) => {
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
        
        function render(frame, session, camera, scene, renderer, referenceSpace) {
            const hitTestSource = session.requestHitTestSource({ space: referenceSpace });
            const xrViewerPose = frame.getViewerPose(referenceSpace);
        
            if (xrViewerPose) {
                const hitTestResults = frame.getHitTestResults(hitTestSource);
                if (hitTestResults.length) {
                    const pose = hitTestResults[0].getPose(referenceSpace);
                    reticle.visible = true;
                    reticle.matrix.fromArray(pose.transform.matrix);
                } else {
                    reticle.visible = false;
                }
        
                const viewMatrix = xrViewerPose.views[0].transform.inverse.matrix;
                const viewProjectionMatrix = xrViewerPose.views[0].projectionMatrix;
        
                camera.projectionMatrix.fromArray(viewProjectionMatrix);
                camera.matrix.fromArray(viewMatrix).getInverse(camera.matrix);
                camera.updateMatrixWorld(true);
        
                renderer.render(scene, camera);
            }
        
            session.requestAnimationFrame((time, frame) => {
                render(frame, session, camera, scene, renderer, referenceSpace);
            });
        }
        
        window.addEventListener('touchstart', onTouchStart, false);
        window.addEventListener('touchmove', onTouchMove, false);
        </script>
        </body>
        </html>
        