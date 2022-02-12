import 'lightgallery/css/lightgallery.css';
import 'lightgallery/css/lg-zoom.css';
import 'lightgallery/css/lg-thumbnail.css';
import lightGallery from 'lightgallery';
import lgZoom from 'lightgallery/plugins/zoom';
import lgThumbnail from 'lightgallery/plugins/thumbnail';

document.addEventListener('DOMContentLoaded', () => {
  lightGallery(document.querySelector('.js-cat-photo-gallery'), {
    plugins: [lgZoom, lgThumbnail],
    selector: '.js-gallery-image',
    mousewheel: true,
  });
});
