import axios from "axios";
import router from "../src/router";
import { eventBus } from "@/main";

//const baseUrl = "http://api.coloradomountainvacationhomes.com/api";
const baseUrl = "https://gas.api.reverbsoft.com/api";
//Customized axios request
var customAxios;
//Service module
let token = "";

const RequestService = {
  post: (endpoint, body, date) => {
    let apiName = "";
    token = localStorage.getItem("token");
    let user = JSON.parse(localStorage.getItem("user"));

    //setting end point for super admin
    if (user.permissions.includes("Companies")) {
      if (endpoint === "customer/read_all") apiName = "customer/read";
      else if (endpoint === "user/read_all") apiName = "user/read";
      else if (endpoint === "sale/read_all") apiName = "sale/read";
      else if (endpoint === "company/read_all") apiName = "company/read";
      else if (endpoint === "purchase/read_all") apiName = "purchase/read";
      else if (endpoint === "dashboard/read_all") apiName = "dashboard/read";
      else if (endpoint === "order/read_all") apiName = "order/read";
      else if (endpoint === "depo/read_all") apiName = "depo/read";
      else if (endpoint === "promo/read_all") apiName = "promo/read";
      else if (endpoint === "transaction/read_all")
        apiName = "transaction/read";
      else apiName = endpoint;
    } else apiName = endpoint; //setting end point for regular user/company
    // if Super admin is updating any data
    if (
      user.permissions.includes("Companies") &&
      body && // 👈 null and undefined check
      Object.keys(body).length !== 0
    ) {
      //if super admin
      if (body.company_id == undefined) {
        body.user_id = user.id; //for token auth
        body.company_id = user.id; //for query
      } else {
        body.user_id = user.id; //for token auth
      }
    } else {
      //if regular user/company
      if ("company_id" in user) {
        //if company created user
        body.user_id = user.company_id;
        body.company_id = user.company_id;
      } else {
        //if company
        body.company_id = user.id;
        body.user_id = user.id;
      }
    }
    if (
      date && // 👈 null and undefined check
      Object.keys(date).length !== 0
    ) {
      body.start_date = date.start_date;
      body.end_date = date.end_date;
    }
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
