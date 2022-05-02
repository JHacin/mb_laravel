import 'lightgallery/css/lightgallery.css';
import 'lightgallery/css/lg-zoom.css';
import 'lightgallery/css/lg-thumbnail.css';
import lightGallery from 'lightgallery';
import lgZoom from 'lightgallery/plugins/zoom';
import lgThumbnail from 'lightgallery/plugins/thumbnail';

document.addEventListener('DOMContentLoaded', () => {
  const element = document.querySelector<HTMLElement>('.js-cat-photo-gallery');

  if (!element) {
    console.error('Could not find the photo gallery instance element.');
    return;
  }

  lightGallery(element, {
    plugins: [lgZoom, lgThumbnail],
    selector: '.js-gallery-image',
    mousewheel: true,
  });
});
