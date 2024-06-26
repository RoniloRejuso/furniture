class ARButton {

    static createButton(renderer, sessionInit = {}) {

        const button = document.createElement('button');
        let currentSession = null;
        let isARSessionActive = false;

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
                    if (currentSession && isARSessionActive) {
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

            async function onSessionStarted(session) {
                session.addEventListener('end', onSessionEnded);

                renderer.xr.setReferenceSpaceType('local');
                await renderer.xr.setSession(session);

                button.textContent = 'STOP AR';
                button.style.background = '#493A2D';
                sessionInit.domOverlay.root.style.display = '';

                currentSession = session;
                isARSessionActive = true;
            }

            function onSessionEnded() {
                currentSession.removeEventListener('end', onSessionEnded);

                button.textContent = 'START AR';
                button.style.background = '#964B33';
                sessionInit.domOverlay.root.style.display = 'none';

                currentSession = null;
                isARSessionActive = false;

                // Automatically refresh the page after stopping AR
                setTimeout(() => {
                    window.location.reload();
                }, 1000); // Refresh after 1 second (adjust timing as needed)
            }

            function createBackButton() {
                const backButton = document.createElement('button');
                backButton.textContent = 'Back';
                backButton.style.position = 'absolute';
                backButton.style.bottom = '20px';
                backButton.style.left = '20px';
                backButton.style.padding = '10px';
                backButton.style.background = '#333';
                backButton.style.color = '#fff';
                backButton.style.border = 'none';
                backButton.style.cursor = 'pointer';
                backButton.addEventListener('click', function () {
                    window.history.back(); // Navigate back in history
                });
                document.body.appendChild(backButton);
            }

            button.style.display = '';
            button.style.cursor = 'pointer';
            button.style.left = 'calc(50% - 50px)';
            button.style.width = '100px';
            button.style.background = '#964B33';
            button.style.color = '#FFFFFF';

            button.textContent = 'START AR';

            button.onmouseenter = function () {
                button.style.opacity = '1.0';
            };

            button.onmouseleave = function () {
                button.style.opacity = '0.5';
            };

            button.onclick = function () {
                if (isARSessionActive) {
                    onSessionEnded();
                } else {
                    navigator.xr
                        .requestSession('immersive-ar', sessionInit)
                        .then(onSessionStarted)
                        .catch((error) => {
                            console.error('Error starting AR session:', error);
                            showARNotSupported();
                        });
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
            element.style.border = 'transparent';
            element.style.borderRadius = '5px';
            element.style.background = '#964B33';
            element.style.color = '#fff';
            element.style.font = 'normal 13px sans-serif';
            element.style.textAlign = 'center';
            element.style.opacity = '0.5';
            element.style.outline = 'none';
            element.style.zIndex = '999';
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
