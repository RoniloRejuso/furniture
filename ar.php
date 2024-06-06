<?php
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "furniture";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        }
    </style>
</head>
<body>
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
    </script>
</body>
</html>
