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

import VueError from "./components/errors/VueError.vue";

const app = createApp({
  components: {
    HomeList,
    CategoryProducts,
    ShowProduct,
    VueError,
    ShoppingCar,
  },
});
app.component("nav-bar", NavBar);
app.component("main-banner", MainBanner);
app.component("v-select", vSelect);
app.mount("#app");
