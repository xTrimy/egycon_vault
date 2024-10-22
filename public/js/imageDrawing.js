document.addEventListener('DOMContentLoaded', function () {
  const canvas = document.getElementById('draw-canvas');
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

  document.getElementById('save-drawing').addEventListener('click', function () {
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
});
