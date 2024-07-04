class ARButton {

    static createButton(renderer, sessionInit = {}) {

        const button = document.createElement('button');

        function showStartAR() {
            if (sessionInit.domOverlay === undefined) {
                // Create overlay and SVG icon
                var overlay = document.createElement('div');
                overlay.style.display = 'none';
                document.body.appendChild(overlay);

                var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svg.setAttribute('width', 38);
                svg.setAttribute('height', 38);
                svg.style.position = 'absolute';
                svg.style.right = '20px';
                svg.style.top = '20px';
                svg.addEventListener('click', function () {
                    if (currentSession) {
                        currentSession.end();
                    }
                });
                overlay.appendChild(svg);

                var path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                path.setAttribute('d', 'M 12,12 L 28,28 M 28,12 12,28');
                path.setAttribute('stroke', '#fff');
                path.setAttribute('stroke-width', 2);
                svg.appendChild(path);

                if (sessionInit.optionalFeatures === undefined) {
                    sessionInit.optionalFeatures = [];
                }

                sessionInit.optionalFeatures.push('dom-overlay');
                sessionInit.domOverlay = { root: overlay };
            }

            let currentSession = null;

            async function onSessionStarted(session) {
                session.addEventListener('end', onSessionEnded);

                // Configure renderer
                renderer.xr.setReferenceSpaceType('local');
                await renderer.xr.setSession(session);

                // Update button state to Capture Image button
                button.innerHTML = ''; // Clear text
                button.style.background = 'transparent';
                button.style.border = '4px solid #fff';
                button.style.borderRadius = '50%';
                button.style.width = '70px'; // Adjust size
                button.style.height = '70px'; // Adjust size
                button.style.position = 'fixed';
                button.style.bottom = '30px';
                button.style.left = '50%';
                button.style.transform = 'translateX(-50%)';
                button.style.display = ''; // Make sure the button is visible
                button.style.cursor = 'pointer';

                sessionInit.domOverlay.root.style.display = '';

                currentSession = session;
            }

            function onSessionEnded() {
                currentSession.removeEventListener('end', onSessionEnded);

                // Update button state
                button.textContent = 'START AR';
                button.style.background = 'transparent';
                button.style.border = '4px solid #fff';
                button.style.borderRadius = '10px';
                button.style.width = '120px';
                button.style.height = 'auto';
                button.style.position = 'fixed';
                button.style.bottom = '20px';
                button.style.left = '50%';
                button.style.transform = 'translateX(-50%)';
                button.style.display = ''; // Make sure the button is visible

                sessionInit.domOverlay.root.style.display = 'none';

                currentSession = null;
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            }

            // Configure button style and behavior
            button.style.display = '';
            button.style.cursor = 'pointer';
            button.style.width = '120px';
            button.style.height = 'auto';
            button.style.background = 'transparent';
            button.style.color = '#FFFFFF';
            button.style.border = '4px solid #fff';
            button.style.borderRadius = '10px';
            button.style.font = 'normal 13px sans-serif';
            button.style.textAlign = 'center';
            button.style.opacity = '0.5';
            button.style.outline = 'none';
            button.style.zIndex = '999';

            button.textContent = 'START AR';

            button.onmouseenter = function () {
                button.style.opacity = '1.0';
            };

            button.onmouseleave = function () {
                button.style.opacity = '0.5';
            };

            button.onclick = function () {
                if (currentSession === null) {
                    navigator.xr
                        .requestSession('immersive-ar', sessionInit)
                        .then(onSessionStarted);
                } else {
                    captureImage();
                }
            };
        }

        function disableButton() {
            button.style.display = '';
            button.style.cursor = 'auto';
            button.style.left = 'calc(50% - 75px)';
            button.style.width = '150px';
            button.onmouseenter = null;
            button.onmouseleave = null;
            button.onclick = null;
        }

        function showARNotSupported() {
            disableButton();
            button.textContent = 'AR NOT SUPPORTED';
        }

        function stylizeElement(element) {
            element.style.position = 'absolute';
            element.style.bottom = '20px';
            element.style.padding = '12px 6px';
            element.style.border = '4px solid #fff';
            element.style.borderRadius = '10px';
            element.style.background = 'transparent';
            element.style.color = '#fff';
            element.style.font = 'normal 13px sans-serif';
            element.style.textAlign = 'center';
            element.style.opacity = '0.5';
            element.style.outline = 'none';
            element.style.zIndex = '999';
        }

        function captureImage() {
            const canvas = document.createElement('canvas');
            canvas.width = renderer.domElement.width;
            canvas.height = renderer.domElement.height;
            const context = canvas.getContext('2d');
            context.drawImage(renderer.domElement, 0, 0);
            const dataURL = canvas.toDataURL('image/jpeg'); // Change to JPEG

            const link = document.createElement('a');
            link.href = dataURL;
            link.download = 'Our_Home_AR.jpg';
            link.click();
        }

        if ('xr' in navigator) {
            button.id = 'ARButton';
            button.style.display = 'none';
            stylizeElement(button);

            navigator.xr.isSessionSupported('immersive-ar').then(function (supported) {
                supported ? showStartAR() : showARNotSupported();
            }).catch(showARNotSupported);

            return button;

        } else {
            const message = document.createElement('a');
            if (window.isSecureContext === false) {
                message.href = document.location.href.replace(/^http:/, 'https:');
                message.innerHTML = 'WEBXR NEEDS HTTPS';
            } else {
                message.href = 'https://immersiveweb.dev/';
                message.innerHTML = 'WEBXR NOT AVAILABLE';
            }
            message.style.left = 'calc(50% - 90px)';
            message.style.width = '180px';
            message.style.textDecoration = 'none';
            stylizeElement(message);
            return message;
        }
    }
}

export { ARButton };
