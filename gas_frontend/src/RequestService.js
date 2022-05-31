import axios from "axios";
import router from "../src/router";
//const baseUrl = "http://api.coloradomountainvacationhomes.com/api";
const baseUrl = "http://127.0.0.1:8000/api";
//Customized axios request
var customAxios;
//Service module
let token = "";

const RequestService = {
  post: (endpoint, body) => {
    token = localStorage.getItem("token");
    console.log("nsde ths");
    let user = JSON.parse(localStorage.getItem("user"));
    body.user_id = user.id;
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
          if (err.response.status == 401) {
            console.log("error 401", err);
            localStorage.clear();
            router.push({ name: "login" });
          }
          reject(err);
        });
    });
  },
};
export default RequestService;
