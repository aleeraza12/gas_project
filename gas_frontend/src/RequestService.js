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
    let apiName = "";
    token = localStorage.getItem("token");
    let user = JSON.parse(localStorage.getItem("user"));
    if (user.permissions.includes("Companies")) {
      if (endpoint === "customer/read_all") apiName = "customer/read";
      else if (endpoint === "user/read_all") apiName = "user/read";
      else if (endpoint === "sale/read_all") apiName = "sale/read";
      else if (endpoint === "company/read_all") apiName = "company/read";
      else if (endpoint === "purchase/read_all") apiName = "purchase/read";
      else if (endpoint === "dashboard/read_all") apiName = "dashboard/read";
      else if (endpoint === "transaction/read_all")
        apiName = "transaction/read";
      else apiName = endpoint;
    } else apiName = endpoint;
    if ("company_id" in user) body.user_id = user.company_id;
    else body.user_id = user.id;
    return new Promise((resolve, reject) => {
      customAxios = axios.create({
        headers: {
          Token: token,
        },
      });
      customAxios
        .post(`${baseUrl}/${apiName}`, body)
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
