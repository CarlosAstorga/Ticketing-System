@extends('templates.main')
@section('styles')
<link href="{{ asset('css/ticket.css') }}" rel="stylesheet">
@endsection
@section('header', 'Ticket #' . $ticket->id)
@section('buttons')
<div class="btn-group">
    <a type="button" class="btn btn-sm btn-outline-secondary" href="{{ route('tickets.index') }}"><i class="fas fa-th-list"></i></a>
</div>
@endsection
@section('button', '')
@section('content')
<div class="card">
    <div class="card-header">Datos generales</div>
    <div class="card-body my-3 my-sm-5">
        <div class="row mb-2">
            <p class="col-12 col-sm-4 text-sm-end mb-0 fw-bold">Asunto</p>
            <p class="col-12 col-sm-8 mb-0">{{ $ticket->title }}</p>
        </div>
        <div class="row mb-2">
            <p class="col-12 col-sm-4 text-sm-end mb-0 fw-bold">Descripción</p>
            <p class="col-12 col-sm-8 mb-0">{{ $ticket->description }}</p>
        </div>
        @can('user_assigment')
        @isset($ticket->project)
        <div class="row align-items-center">
            <p class="col-12 col-sm-4 text-sm-end mb-0 fw-bold">Proyecto</p>
            <p class="col-12 col-sm-8 mb-0">{{ $ticket->project->title }}</p>
        </div>
        @endisset
        @endcan
    </div>
</div>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <p class="mb-0 align-self-center">Subir archivos</p>
        <div class="btn-group">
            <button id="fileUploadButton" type="button" class="btn btn-sm btn-outline-secondary fas fa-upload" disabled></button>
            <button id="fileButton" class="btn btn-sm btn-outline-secondary">Examinar...</button>
            <input type="file" class="form-control d-none" multiple accept=".jpg, .png" name="image" id="file">
        </div>
    </div>
    <p id="fileMessage" class="text-center py-3 fw-light fst-italic mb-0 border-bottom">Sin archivos seleccionados</p>
    <ul id="fileListContainer" class="card-body py-0 mb-0">
    </ul>
</div>
<div class="card">
    <div class="card-header">Archivos</div>
    <div class="card-body">
        <div id="gallery" class="gallery"></div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-body bg-dark position-relative">
                <div class="modal-buttons">
                    <a id="downloadButton" class="btn btn-sm btn-light modal-button" href="#"><i class="fas fa-file-download "></i></a>
                    <a class="btn btn-sm btn-danger modal-button" data-bs-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></a>
                </div>
                <div class="preview-container">
                    <div id="previewOverlay" class="overlay"></div>
                    <img class="preview-image" id="preview">
                </div>
                <div class="thumbnail-roll"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    let fileList = [];
    let uploading = false;
    const token = document.querySelector('meta[name="csrf-token"]').content;
    const path = "/storage/images/tickets";
    const ticketId = '{{ $ticket->id }}';
    const fileInput = document.getElementById('file');
    const fileButton = document.getElementById('fileButton');
    const fileMessage = document.getElementById('fileMessage');
    const fileUploadButton = document.getElementById('fileUploadButton');
    const fileListContainer = document.getElementById('fileListContainer');
    const downloadButton = document.getElementById('downloadButton');
    const previewOverlay = document.getElementById('previewOverlay');
    const preview = document.getElementById('preview');
    const gallery = document.getElementById('gallery');
    const roll = document.querySelector('.thumbnail-roll');

    renderGallery();

    /*********************************
     <-----* L I S T E N E R S *----->
     ********************************/
    fileButton.addEventListener('click', () => fileInput.click());

    fileUploadButton.addEventListener('click', () => {
        const files = fileList.filter(
            file => file.visible && file.success
        );

        files.forEach(file => {
            uploadFile(file);
        });
    });

    fileInput.addEventListener('change', () => {
        handleSelectedFiles();
        event.target.value = '';
    });

    /*********************************************************
     <--------------------* I M A G E S *-------------------->
     ********************************************************/
    /** 
     * Renders gallery images.
     */
    function renderGallery() {
        const storedFiles = JSON.parse('@json($ticket->files)');
        if (!storedFiles.length) return;

        const imageFragment = document.createDocumentFragment();
        const thumbnailFragment = document.createDocumentFragment();

        for (const image of storedFiles) {
            imageFragment.appendChild(createGalleryImage(image));
            thumbnailFragment.appendChild(createThumbnail(image));
        }

        gallery.appendChild(imageFragment);
        roll.appendChild(thumbnailFragment)
    }

    /**
     * Creates an image for the gallery.
     * @param {Object} image - The image to be displayed.
     */
    function createGalleryImage(image) {
        const container = document.createElement('div');
        container.classList = 'image-container';
        container.innerHTML = `
            <div class="overlay"></div>
            <img class="thumbnail" src="${path}/${image.ticket_id}/${image.name}" data-bs-toggle="modal" data-bs-target="#modal" />
            <span class="far fa-trash-alt image-button"></span>`

        const children = container.children;
        children[0].style.backgroundImage = `url(${path}/${image.ticket_id}/${image.name})`;
        children[1].addEventListener('click', () => handleImageClick(image.id));
        children[2].addEventListener('click', () => deleteFile(image.id, container));
        return container;
    }

    /**
     * Creates a thumbnail.
     * @param {Object} image - The image to be displayed.
     */
    function createThumbnail(image) {
        const img = document.createElement('img');
        img.id = `image-${image.id}`;
        img.src = `${path}/${image.ticket_id}/${image.name}`;
        img.classList = 'roll-thumbnail';
        img.addEventListener('click', () => handleImageClick(image.id));
        return img;
    }

    /**
     * Event handler for image click.
     * @param {number} id - Image id.
     */
    function handleImageClick(id) {
        if (event.target.classList.contains('active')) return;
        const active = document.querySelector('.thumbnail-roll > .active');;
        if (active) active.classList.remove('active');
        preview.src = event.target.src;
        downloadButton.href = `/files/${id}/download`;
        document.getElementById(`image-${id}`).classList.add('active');
        previewOverlay.style.backgroundImage = `url(${event.target.src})`;
    }

    /** 
     * Validates the image.
     * @param {Object} image - The image to be validated.
     * @param {number} sizeLimit - The kb limit.
     * @param {array} fileExtensions - The file possible extensions.
     */
    function validateImage(image, sizeLimit, fileExtensions = ['jpeg', 'png']) {
        let message = null;
        const extension = image.type.split('/').pop();
        if (image.size > sizeLimit) message = 'Limite de tamaño excedido';
        if (!fileExtensions.includes(extension)) message = 'Extensión de archivo no permitido';
        return message;
    }

    /*********************************************************
     <---------------------* F I L E S *--------------------->
     ********************************************************/

    /** 
     * Updates the file list array based on the selected files.
     */
    function handleSelectedFiles() {
        for (const file of fileInput.files) {
            const exists = fileList.find(item =>
                item.file.name == file.name
            );

            if (exists) exists.visible = true;
            else fileList.push({
                index: fileList.length + 1,
                file: file,
                visible: true,
                success: false
            });
        }

        fileList.forEach(file => {
            if (file.visible && !document.getElementById(file.index))
                fileListContainer.appendChild(createFileRow(file));
        });

        updateFileMessage();
        updateUploadButton();
    }

    /**
     * Creates a li node with the file's data.
     * @param {Object} file - The file. 
     */
    function createFileRow(file) {
        const message = validateImage(file.file, 3000000);
        file.success = message ? false : true;
        const row = document.createElement('li');
        row.classList = 'row g-0 border-bottom';
        row.id = file.index;
        row.innerHTML =
            `<div class="col-10 col-lg-11 row g-0 align-self-center">
                <div class="col-12 col-lg-8">
                    <p class="mb-0 overflow-hidden">${file.file.name}</p>
                </div>
                <div class="col-12 col-lg-1 align-self-center">
                    <p class="mb-0 fw-light">${formatBytes(file.file.size)}</p>
                </div>
                <div class="col-12 col-lg align-self-center">
                    <p class="${message ? 'text-danger fw-light mb-0' 
                        : 'text-success fw-light mb-0'}">${message ? message : 'Listo para subir'}</p>
                </div>
            </div>
            <div class="col-2 col-lg-1 d-flex justify-content-end">
                <i class="fas fa-times px-3 py-3 my-auto btn-hover"></i>
            </div>`
        row.lastElementChild.firstElementChild.addEventListener('click', () => removeRow(file.index));
        return row;
    }

    /**
     * Removes row and updates its dependencies.
     * @param {number} id - row's id.
     */
    function removeRow(id) {
        document.getElementById(id).remove();
        updateFileMessage();
        updateUploadButton();
        fileList[id - 1].visible = false;
    }

    /**
     * Updates the message with the row count.
     */
    function updateFileMessage() {
        const childrenCount = fileListContainer.childElementCount;
        fileMessage.textContent = childrenCount ? `${childrenCount} Archivos seleccionados` : 'Sin archivos seleccionados';
    }

    /**
     * Updates the upload button.
     */
    function updateUploadButton() {
        if (document.querySelector('.text-danger')) fileUploadButton.disabled = true;
        else if (!fileListContainer.childElementCount) fileUploadButton.disabled = true;
        else if (uploading) fileUploadButton.disabled = true;
        else fileUploadButton.disabled = false;
    }

    /** 
     * Format bytes.
     * @param {number} a - bytes
     * @param {number} b - decimals.
     */
    function formatBytes(a, b = 2) {
        if (0 === a) return "0 Bytes";
        const c = 0 > b ? 0 : b,
            d = Math.floor(Math.log(a) / Math.log(1024));
        return parseFloat((a / Math.pow(1024, d)).toFixed(c)) + " " + ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"][d]
    }

    /**
     * Uploads the file.
     * @param {Object} file - File to be uploaded.
     */
    function uploadFile(file) {
        let isOk = true;
        const row = document.getElementById(file.index);
        const icon = row.lastElementChild;
        const status = row.firstElementChild.lastElementChild.firstElementChild;
        status.textContent = "Subiendo...";
        icon.innerHTML =
            `<div class="spinner-border spinner-border-sm mx-3 my-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>`;

        let formData = new FormData();
        formData.append('file', file.file);
        fetch(`/tickets/${ticketId}/upload`, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": token
                }
            })
            .then(response => {
                uploading = true;
                if (!response.ok) isOk = false;
                return response.json()
            })
            .then(response => {
                if (!isOk) throw Error(response.file[0]);
                return response;
            })
            .then(result => {
                removeRow(file.index);
                gallery.appendChild(createGalleryImage(result));
                roll.appendChild(createThumbnail(result));
                uploading = false;
            }).catch(error => {
                uploading = false;
                status.textContent = error;
                icon.innerHTML = '<i class="fas fa-times px-3 py-3 my-auto btn-hover"></i>';
                icon.addEventListener('click', () => removeRow(file.index));
            });
    }

    /**
     * Deletes the stored file.
     * @param {number} id - file's id.
     */
    function deleteFile(id, image) {
        fetch('/files/' + id, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": token
            }
        }).then(response => response.json()).then(response => {
            if (response) {
                image.remove();
                document.getElementById(`image-${id}`).remove();
            }
        });
    }
</script>
@endsection