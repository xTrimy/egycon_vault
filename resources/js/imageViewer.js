import 'viewerjs/dist/viewer.css';
import Viewer from 'viewerjs';
const singleImageViewer = new Viewer(document.getElementById('viewer-image'), {
    toolbar: false,
    navbar: false,
    movable: false,
    rotatable: false,
    scalable: false,
    viewed() {
        
        viewer.zoomTo(1);
    },
});