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
                <button type="button" class="btn btn-outline-light d-flex align-items-center gap-2" id="capture">Capturar</button>
                <button type="button" class="btn btn-success" id="savePhoto" data-bs-dismiss="modal" disabled>Salvar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureButton = document.getElementById('capture');
    const savePhotoButton = document.getElementById('savePhoto');
    const modalCamera = document.getElementById('modalCamera'); // Obtém a referência do modal
    const userImageInput = document.getElementById('user-image');
    let stream;
    let capturedImageBlob = null;
    const photoPreview = document.getElementById('photo'); // Certifique-se de que este elemento existe no seu formulário

    // Iniciar a câmera quando o modal abrir
    modalCamera.addEventListener('shown.bs.modal', async function () {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        } catch (error) {
            alert('Não foi possível acessar a câmera: ' + error.message);
        }
    });

    // Parar a câmera quando o modal fechar
    modalCamera.addEventListener('hidden.bs.modal', function () {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        // Resetar o estado
        savePhotoButton.disabled = true;
        canvas.classList.add('d-none');
        video.classList.remove('d-none');
    });

    // Capturar a imagem e desenhá-la no canvas
    captureButton.addEventListener('click', function () {
        const context = canvas.getContext('2d');
        const videoWidth = video.offsetWidth;
        const videoHeight = video.offsetHeight;

        canvas.width = videoWidth;
        canvas.height = videoHeight;
        context.drawImage(video, 0, 0, videoWidth, videoHeight);

        // Alternar entre vídeo e canvas
        canvas.classList.remove('d-none');
        video.classList.add('d-none');
        savePhotoButton.disabled = false;
    });

    savePhotoButton.addEventListener('click', function () {
        canvas.toBlob(function(blob) {
            capturedImageBlob = blob;

            if (photoPreview) {
                photoPreview.src = URL.createObjectURL(capturedImageBlob);
            }

            if (capturedImageBlob) {
                const fileName = `captured_${Date.now()}.png`;
                const file = new File([capturedImageBlob], fileName, { type: 'image/png' });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                userImageInput.files = dataTransfer.files;
            }
        }, 'image/png');
    });

    // Se o usuário escolher arquivo manualmente
    userImageInput.addEventListener('change', function() {
        capturedImageBlob = null; // reseta foto capturada da câmera, se tiver

        if (photoPreview && this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                photoPreview.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
        } else if (photoPreview) {
            photoPreview.src = "{{ Vite::asset('/resources/images/avatar.png') }}"; // imagem padrão
        }
    });
});
</script>