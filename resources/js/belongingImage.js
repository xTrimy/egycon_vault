import imageCompression from 'browser-image-compression';

const input = document.getElementById('belonging-image-input');
const imageContainer = document.getElementById('belonging-image');
const form = document.getElementById('belonging-image-form');
const loader = document.getElementById('image-loader');
input.addEventListener('change', function () {
    const file = this.files[0];
    const reader = new FileReader();
    reader.onload = function () {
        const img = createImageEl(reader.result);
        imageContainer.innerHTML = '';
        imageContainer.appendChild(img);
        const filename = file.name;
        const options = {
            maxWidthOrHeight: 800,
            maxIteration: 4
        };
        loader.classList.remove('hidden');
        imageCompression(file, options)
            .then(function (compressedFile) {
                const reader = new FileReader();
                reader.onload = function () {
                    const img = createImageEl(reader.result);
                    imageContainer.innerHTML = '';
                    imageContainer.appendChild(img);
                };
                reader.readAsDataURL(compressedFile);
                let file = new File([compressedFile], filename, { type: "mime/image", lastModified: new Date().getTime() });
                let container = new DataTransfer();
                container.items.add(file);
                input.files = container.files;
                console.log(input.files);
                console.log("Size of new file: " + file.size);
                console.log("In mega bytes: " + file.size / (1024 * 1024));
            })
            .catch(function (error) {
                console.error('Failed to compress the image', error);
            }).finally(() => {
                loader.classList.add('hidden');
                form.submit();
            });



    };
    if (!(file instanceof Blob)) {
        imageContainer.innerHTML = '';
        imageContainer.classList.add('hidden');
        return;
    }
    reader.readAsDataURL(file);
    imageContainer.classList.remove('hidden');
});

const createImageEl = function (url) {
    const img = document.createElement('img');
    img.src = url;
    img.classList.add('w-full');
    return img;
};
