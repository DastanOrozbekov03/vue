import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router/index.js";
// import store from "./store/index.js";
import "preline/preline";

let app =  createApp(App);


app.use(router)
// app.use(store)
app.mount("#app");
