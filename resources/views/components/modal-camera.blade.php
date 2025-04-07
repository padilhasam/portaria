<div class="modal fade" id="modalCamera" tabindex="-1" aria-labelledby="modalCameraLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-0 overflow-hidden" style="background: #111; color: #fff; border-radius: 1rem;">
            <div class="modal-header border-0 p-3" style="background: #1a1a1a;">
                <h5 class="modal-title" id="modalCameraLabel">📸 Tirar Foto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body text-center">
                <video id="video" width="100%" autoplay playsinline class="rounded shadow-sm"></video>
                <canvas id="canvas" class="d-none"></canvas>
            </div>
            <div class="modal-footer d-flex justify-content-between border-0 p-3" style="background: #1a1a1a;">
                <button type="button" class="btn btn-outline-light d-flex align-items-center gap-2" id="capture"></i>Capturar</button>
                <button type="button" class="btn btn-success" id="savePhoto" data-bs-dismiss="modal" disabled>Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let video = document.getElementById('video');
    let canvas = document.getElementById('canvas');
    let photo = document.getElementById('photo');
    let captureButton = document.getElementById('capture');
    let saveButton = document.getElementById('savePhoto');
    let stream;

    $('#modalCamera').on('shown.bs.modal', function () {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(s) {
                stream = s;
                video.srcObject = stream;
                video.play();
            })
            .catch(function(err) {
                console.error("Erro ao acessar a câmera: ", err);
            });
        }
    });

    $('#modalCamera').on('hidden.bs.modal', function () {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
    });

    captureButton.addEventListener('click', function () {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        saveButton.disabled = false;
    });

    saveButton.addEventListener('click', function () {
        let dataURL = canvas.toDataURL('image/png');
        photo.src = dataURL;

        // Opcional: Colocar a foto no input file se quiser salvar depois
        fetch(dataURL)
            .then(res => res.blob())
            .then(blob => {
                const file = new File([blob], "webcam-photo.png", { type: "image/png" });
                const container = new DataTransfer();
                container.items.add(file);
                document.getElementById('user-image').files = container.files;
            });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const userImageInput = document.getElementById('user-image');
        const photoPreview = document.getElementById('photo');

        if (userImageInput && photoPreview) {
            userImageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureButton = document.getElementById('capture');
    const saveButton = document.getElementById('savePhoto');
    let stream;

    // Quando o modal abrir, iniciar a câmera
    const modalCamera = document.getElementById('modalCamera');
    modalCamera.addEventListener('shown.bs.modal', async function () {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        } catch (error) {
            alert('Não foi possível acessar a câmera: ' + error.message);
        }
    });

    // Quando o modal fechar, parar a câmera
    modalCamera.addEventListener('hidden.bs.modal', function () {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        // Resetar botões e canvas
        saveButton.disabled = true;
        canvas.classList.add('d-none');
        video.classList.remove('d-none');
    });

    // Capturar a imagem
    captureButton.addEventListener('click', function () {
    const context = canvas.getContext('2d');

    // Ajustar o canvas para o tamanho visível do vídeo no modal
    const videoWidth = video.offsetWidth;
    const videoHeight = video.offsetHeight;
    canvas.width = videoWidth;
    canvas.height = videoHeight;

    // Agora desenhar a imagem proporcional
    context.drawImage(video, 0, 0, videoWidth, videoHeight);

    // Mostrar o canvas no lugar do vídeo
    canvas.classList.remove('d-none');
    video.classList.add('d-none');
    saveButton.disabled = false;
    });

    // Quando clicar em "Salvar", você pode pegar a imagem
    saveButton.addEventListener('click', function () {
        const photoDataUrl = canvas.toDataURL('image/png');

        // Exemplo: colocar a foto em outro lugar da página
        const imgPreview = document.getElementById('photo'); // precisa ter um <img id="photo">
        if (imgPreview) {
            imgPreview.src = photoDataUrl;
        }

        // OU você pode mandar isso para um <input type="hidden"> pra salvar no back-end
        const inputHidden = document.getElementById('photoInput'); // precisa ter <input type="hidden" id="photoInput">
        if (inputHidden) {
            inputHidden.value = photoDataUrl;
        }
    });
});
    
</script>
