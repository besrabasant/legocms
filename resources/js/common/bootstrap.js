import Turbolinks from 'turbolinks';
import dd from '../utils/dd';

window.Turbolinks = Turbolinks;
window.dd = dd;

export default {
    init() {
        Turbolinks.start();
        Turbolinks.setProgressBarDelay(100);
    }
}
