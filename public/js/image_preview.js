function showPreview(event) {
    const files = event.target.files;
    const previewContainer = document.querySelector('.preview-container');

    for (const file of files) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const previewImage = document.createElement('div');
            previewImage.className = 'preview-image';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Image Preview';
            img.className = 'img-fluid img-thumbnail';
            previewImage.appendChild(img);

            const deleteIcon = document.createElement('i');
            deleteIcon.className = 'fas fa-times delete-icon';
            deleteIcon.onclick = function () {
                previewImage.remove();
            };
            previewImage.appendChild(deleteIcon);

            // Add click event to view image in modal
            img.onclick = function () {
                showModal(img.src);
            };

            previewContainer.appendChild(previewImage);
        };

        reader.readAsDataURL(file);
    }
    
    // Clear the input value to allow selecting the same file again
    event.target.value = '';
}

function showModal(src) {
    const modal = document.createElement('div');
    modal.className = 'modal';

    const modalContent = document.createElement('div');
    modalContent.className = 'modal-content';

    const img = document.createElement('img');
    img.src = src;
    modalContent.appendChild(img);

    const closeModal = document.createElement('span');
    closeModal.className = 'modal-close';
    closeModal.innerHTML = '&times;';
    closeModal.onclick = function () {
        modal.style.display = 'none';
        modal.remove();
    };
    modalContent.appendChild(closeModal);

    modal.appendChild(modalContent);
    document.body.appendChild(modal);

    modal.style.display = 'block';
}
