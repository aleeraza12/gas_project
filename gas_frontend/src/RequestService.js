import axios from "axios";
import router from "../src/router";
import { eventBus } from "@/main";

//const baseUrl = "http://api.coloradomountainvacationhomes.com/api";
const baseUrl = "http://127.0.0.1:8000/api";
//Customized axios request
var customAxios;
//Service module
let token = "";

const RequestService = {
  post: (endpoint, body) => {
    token = localStorage.getItem("token");
    let user = JSON.parse(localStorage.getItem("user"));
    if ("company_id" in user) body.user_id = user.company_id;
    else body.user_id = user.id;
    return new Promise((resolve, reject) => {
      customAxios = axios.create({
        headers: {
          Token: token,
        },
      });
      customAxios
        .post(`${baseUrl}/${endpoint}`, body)
        .then((res) => {
          resolve(res);

          if (res.data.status == 401) {
            localStorage.clear();
            router.push("/login");
          }
        })
        .catch((err) => {
          reject(err);
          if (err.response.status == 422) {
            eventBus.$emit("validationFailed", err);
          } else {
            this.snackbarMsg = "Something went wrong";
          }
        });
    });
  },
};
export default RequestService;
