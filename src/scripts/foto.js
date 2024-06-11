        document.addEventListener("DOMContentLoaded", function() {
            const video = document.getElementById("camera");
            const canvas = document.getElementById("canvas");
            const preview = document.getElementById("preview");
            const captureButton = document.getElementById("capture");
            const photoInput = document.getElementById("photo");

            // Acessar a câmera
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error("Erro ao acessar a câmera: ", err);
                });

            // Capturar a foto
            captureButton.addEventListener("click", function() {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext("2d");
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                canvas.toBlob(function(blob) {
                    const file = new File([blob], "photo.png", { type: "image/png" });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    photoInput.files = dataTransfer.files;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                });
            });
        });
   