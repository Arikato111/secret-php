// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.22.2/firebase-analytics.js";
import {
  GoogleAuthProvider,
  getAuth,
  signInWithPopup,
} from "https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyC_xhnTCTx-BR9hfRrpzdYCJsGVrCRjw98",
  authDomain: "aden-5ff37.firebaseapp.com",
  projectId: "aden-5ff37",
  storageBucket: "aden-5ff37.appspot.com",
  messagingSenderId: "405613900065",
  appId: "1:405613900065:web:9c2ff427797950088d4e60",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const GoogleProvider = new GoogleAuthProvider();

async function loginGoogle() {
  const auth = getAuth();
  const data = await signInWithPopup(auth, GoogleProvider);
  console.log(data.user.uid.length);
  const form = new FormData();
  form.append("google-token", data.user.uid);
  fetch("/api/google-connect", {
    method: "POST",
    body: form,
  })
    .then((res) => res.text())
    .then((data) => window.location.reload());
}
const ConnectGoogleBtn = document.getElementById("getConnectGoogle");
if (ConnectGoogleBtn) ConnectGoogleBtn.onclick = loginGoogle;

const LoginBtn = document.getElementById("getLogin");
if (LoginBtn)
  LoginBtn.onclick = async () => {
    const auth = getAuth();
    const data = await signInWithPopup(auth, GoogleProvider);
    const form = new FormData();
    console.log(data.user.uid)
    form.append("google-token", data.user.uid);
    fetch("/api/login-by-google", {
      method: "POST",
      body: form,
    }).then(res => res.json()).then(data => {
        console.log(data)
        if(data.status == 1) window.location.replace('/')
        else {
            alert("บัญชีไม่ถูกต้อง หรือยังไม่ได้ทำการผูกบัญชี กรุณาลองใหม่อีกคร้ัง")
        }
    });
  };
