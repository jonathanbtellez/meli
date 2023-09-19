import "./bootstrap";
import { createApp } from "vue";
import vSelect from "vue-select";

// Components ---------------------------------------------------
import NavBar from "./components/components/NavBar.vue";
import HomeList from "./components/components/HomeList.vue";

const app = createApp({
  components: {
    NavBar,
    HomeList,
  },
});

app.component("v-select", vSelect);
app.mount("#app");
