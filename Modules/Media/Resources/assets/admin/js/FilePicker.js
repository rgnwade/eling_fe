import MediaPicker from './MediaPicker';

export default class {
    constructor() {
        $('.file-picker').on('click', (e) => {
            this.pickFile(e);
        });
        this.sortable();
        this.removeFileEventListener();
    }

    pickFile(e) {
        let inputName = e.currentTarget.dataset.inputName;
        let multiple = e.currentTarget.hasAttribute('data-multiple');

        let picker = new MediaPicker({ type: 'application', multiple });

        picker.on('select', (file) => {
            this.addImage(inputName, file, multiple, e.currentTarget);
        });
    }

    addImage(inputName, file, multiple, target) {
        let html = this.getTemplate(inputName, file);

        if (multiple) {
            let multipleImagesWrapper = $(target).next('.multiple-images');

            multipleImagesWrapper.find('.image-holder.placeholder').remove();
            multipleImagesWrapper.find('.image-list').append(html);
        } else {
            $(target).siblings('.single-image').html(html);
        }
    }

    getTemplate(inputName, file) {
        return $(`
            <div class="file-holder">
                ${file.filename}
                <button type="button" class="btn remove-file"></button>
                <input type="hidden" name="${inputName}" value="${file.id}">
            </div>
        `);
    }

    sortable() {
        let imageList = $('.image-list');

        if (imageList.length > 0) {
            Sortable.create(imageList[0], { animation: 150 });
        }
    }

    removeFileEventListener() {
        $('.file-holder-wrapper').on('click', '.remove-file', (e) => {
            e.preventDefault();

            let imageHolderWrapper = $(e.currentTarget).closest('.file-holder-wrapper');

            if (imageHolderWrapper.find('.file-holder').length === 1) {
                imageHolderWrapper.html(
                    this.getImagePlaceholder(e.currentTarget.dataset.inputName)
                );
            }

            $(e.currentTarget).parent().remove();
        });
    }

    getImagePlaceholder(inputName) {
        return `
            <div class="file-holder">
               No File
                <input type="hidden" name="${inputName}">
            </div>
        `;
    }
}
