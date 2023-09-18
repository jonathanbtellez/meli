import "./bootstrap";
import { createApp, defineAsyncComponent } from "vue";
import vSelect from "vue-select";

// Components ---------------------------------------------------
import NavBar from "./components/layout/NavBar.vue";

const app = createApp({
  components: {
    NavBar,
  },
});

app.component("v-select", vSelect);
app.mount("#app");
