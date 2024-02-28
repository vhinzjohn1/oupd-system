import Popper from "@popperjs/core/dist/umd/popper.js";
import jQuery from "jquery";
import axios from "axios";
import "bootstrap";

window.Popper = Popper;
window.$ = window.jQuery = jQuery;

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
