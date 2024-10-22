document.addEventListener('DOMContentLoaded', function () {
  const canvas = document.getElementById('draw-canvas');
  if (!canvas) return;
  const drawOnImageButton = document.getElementById('draw-on-image');
  const saveDrawingButton = document.getElementById('save-drawing');
  const cancelDrawingButton = document.getElementById('cancel-drawing');
  const belongingImageContainer = document.getElementById('belonging-image-container');
  const belongingImageEditorContainer = document.getElementById('belonging-image-editor-container');
  const belongingImageEditorOverlay = document.getElementById('belonging-image-editor-overlay');
  saveDrawingButton.style.display = 'none';
  cancelDrawingButton.style.display = 'none';
  let enableDrawing = false;
  canvas.style.display = 'none';
  const ctx = canvas.getContext('2d');
  let drawing = false;

  function startDrawing(e) {
    drawing = true;
    ctx.beginPath();
    ctx.moveTo(e.offsetX, e.offsetY);
  }

  function draw(e) {
    if (!drawing) return;
    ctx.lineTo(e.offsetX, e.offsetY);
    ctx.stroke();
  }

  function stopDrawing() {
    drawing = false;
  }

  canvas.addEventListener('mousedown', startDrawing);
  canvas.addEventListener('mousemove', draw);
  canvas.addEventListener('mouseup', stopDrawing);
  canvas.addEventListener('mouseout', stopDrawing);

  saveDrawingButton.addEventListener('click', function () {
    enableDisableDrawing(false);
    const route = this.getAttribute('data-route');  // Get route from data attribute

    const image = document.getElementById('viewer-image');
    const combinedCanvas = document.createElement('canvas');
    combinedCanvas.width = canvas.width;
    combinedCanvas.height = canvas.height;
    const combinedCtx = combinedCanvas.getContext('2d');

    // Draw the image and then the drawing
    combinedCtx.drawImage(image, 0, 0, canvas.width, canvas.height);
    combinedCtx.drawImage(canvas, 0, 0);

    // Convert to base64 and send to server
    const dataURL = combinedCanvas.toDataURL('image/png');
    image.src = dataURL;
    fetch(route, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({ image: dataURL })
    })
      .then(response => response.json())
      .then(data => {
        alert('Image saved successfully!');
      })
      .catch(error => {
        console.error('Error saving image:', error);
      });
  });

  const enableDisableDrawing = function (enable) {
    enableDrawing = enable != null ? enable : !enableDrawing;
    if (enableDrawing) {
      drawOnImageButton.style.display = 'none';
      cancelDrawingButton.style.display = 'block';
      saveDrawingButton.style.display = 'block';
      canvas.style.display = 'block';
      belongingImageContainer.style = 'transform:scale(2) translateY(-25%);';
      belongingImageEditorContainer.style = "position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); z-index:100;"
      belongingImageEditorOverlay.style = "position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(255,255,255,0.5); z-index:99;"
    } else {
      drawOnImageButton.style.display = 'block';
      cancelDrawingButton.style.display = 'none';
      saveDrawingButton.style.display = 'none';
      canvas.style.display = 'none';
      belongingImageContainer.style = '';
      belongingImageEditorContainer.style = '';
      belongingImageEditorOverlay.style = '';
    };

  }
  drawOnImageButton.addEventListener('click', enableDisableDrawing);
  cancelDrawingButton.addEventListener('click', function () {
    enableDisableDrawing(false);
    ctx.clearRect(0, 0, canvas.width, canvas.height);
  });
});
