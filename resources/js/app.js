import "./bootstrap";
import { createApp } from "vue";
import vSelect from "vue-select";

// Components ---------------------------------------------------
import NavBar from "./components/components/NavBar.vue";
import HomeList from "./components/components/HomeList.vue";
import CategoryProducts from "./components/category/CategoryProducts.vue";

const app = createApp({
  components: {
    NavBar,
    HomeList,
    CategoryProducts,
  },
});

app.component("v-select", vSelect);
app.mount("#app");
