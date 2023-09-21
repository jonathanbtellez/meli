import "./bootstrap";
import { createApp } from "vue";
import vSelect from "vue-select";

// Components ---------------------------------------------------
import NavBar from "./components/components/NavBar.vue";
import MainBanner from "./components/components/MainBanner.vue";
import HomeList from "./components/components/HomeList.vue";
import CategoryProducts from "./components/category/CategoryProducts.vue";
import ShowProduct from "./components/product/ShowProduct.vue";
import ShoppingCar from "./components/shopping/ShoppingCar.vue";
import Footer from "./components/components/Footer.vue";
import ShowUser from "./components/user/ShowUser.vue";
import VueError from "./components/errors/VueError.vue";

// Toast
import ToastPlugin from "vue-toast-notification";

const app = createApp({
  components: {
    ShowUser,
    HomeList,
    CategoryProducts,
    ShowProduct,
    VueError,
    ShoppingCar,
    Footer,
  },
});
app.component("nav-bar", NavBar);
app.component("main-banner", MainBanner);
app.component("v-footer", Footer);
app.component("v-select", vSelect);
app.use(ToastPlugin);
app.mount("#app");
