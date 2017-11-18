'use strict';

class ImageHelper {
    constructor(maxWidth, maxHeight) {
      this.canvas = document.createElement('canvas');
      this.ctx = this.canvas.getContext('2d');
      this.maxWidth = maxWidth;
      this.maxHeight = maxHeight;
    }

    getScaledImageDataUrl(img, w, h) {
        let scale = 1;
        if(w > h && w > this.maxWidth) {
          scale = this.maxWidth / w;
          w = this.maxWidth;
          h = h * scale;
        } else if(h >= w && h > this.maxHeight) {
          scale = this.maxHeight / h;
          h = this.maxHeight;
          w = w * scale;
        }

        this.canvas.width = w;
        this.canvas.height = h;
        this.ctx.drawImage(img, 0, 0, w, h);

        return this.canvas.toDataURL();
    }
}