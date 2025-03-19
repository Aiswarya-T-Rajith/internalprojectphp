import React, { useState } from "react";
import axios from 'axios';

function ForgotPassword() {
  const [email,setEmail]=useState("");
  const [errorMessage, setErrorMessage] = useState("");
  const [successMessage, setSuccessMessage] = useState("");
 async function handleSubmit(){

    if(email === ""){
      setErrorMessage("Email field is required");
    }else if(!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)){
      setErrorMessage("Enter a valid email");
    }else{
      localStorage.setItem('email',email);
      try {
        const response = await axios.post("http://localhost:8001/api/forgotpassword", { email });
        setSuccessMessage(response.data.message);
        localStorage.setItem("resetPasswordToken",response.data.token);
      } catch (error) {
        setErrorMessage(error.response.data.errors.email[0]);
      }
    }
  }
  return (
    <div className="d-flex justify-content-center align-items-center vh-100">
      <div className="card text-center" style={{ width: "350px" }}>
        <div className="card-header h5 text-white bg-primary">
          Forgot password
        </div>
        {errorMessage && <p className="text-danger mt-3">** {errorMessage}</p>}
        {successMessage && <p className="text-success mt-3">✔ {successMessage}</p>}
        <div className="card-body px-5">
          <p className="card-text py-2">
            Provide the email address associated with your account to recover your password.
          </p>
          <div data-mdb-input-init className="form-outline">
            <input type="email" id="email" className="form-control my-3" placeholder="Email" onChange={(e)=>setEmail(e.target.value)}/>
          </div>
          <button type="submit" data-mdb-ripple-init className="btn btn-primary w-100" onClick={handleSubmit}>
            Reset password
          </button>
          <div className="mt-4">
            <a href="/">
              Back to Login
            </a>
          </div>
        </div>
      </div>
    </div>
  );
}

export default ForgotPassword;
