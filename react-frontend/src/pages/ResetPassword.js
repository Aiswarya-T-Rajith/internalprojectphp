import { React, useState } from 'react';
import { Eye, EyeOff } from "lucide-react";
import axios from 'axios';
import Swal from 'sweetalert2';
import { useNavigate } from "react-router-dom";


function ResetPassword() {
  const navigate = useNavigate();
  const [errorMessage, setErrorMessage] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [passwordToggle, setPasswordToggle] = useState(false);
  const [confirmPasswordToggle, setConfirmPasswordToggle] = useState(false);
  const resetPasswordToken = localStorage.getItem('resetPasswordToken');
  const email = localStorage.getItem('email');

  const togglePassword=(field)=>{
    if(field==="passwordField"){
      setPasswordToggle((prev)=>!prev);
    }else if (field === "confirmPasswordField"){
      setConfirmPasswordToggle((prev)=>!prev);
    }
  }
  function validate(){
    if((password || confirmPassword) === ""){
      setErrorMessage("Password field is empty");
      return false;
    }else if(password.length<=6){
      setErrorMessage("Password should contain atleast 6 characters");
      return false;
    }else if(!/[a-z]/.test(password)){
      setErrorMessage("Password should contain atleast one lowercase letter");
      return false;
    }else if(!/[A-Z]/.test(password)){
      setErrorMessage("Password should contain atleast one uppercase letter");
      return false;
    }else if(!/\d/.test(password)){
      setErrorMessage("Password should contain atleast one digit (0-9)");
      return false;
    }else if(!/[@$!%*?&]/.test(password)){
      setErrorMessage("Password should contain atleast one special character");
      return false;
    }else if(/\s/.test(password)){
      setErrorMessage("Password should not contain any white space in between");
      return false;
    }else if(password !== confirmPassword){
      setErrorMessage("Password and confirm password doesnot match");
      return false;
    }else{
      return true;
    }
  }
   async function handleSubmit(){
    console.log("inside handle");
    if(validate()){
      const formData ={
        email : email,
        token : resetPasswordToken,
        password : password,
        password_confirmation : confirmPassword
      }
      console.log(formData);
      try{
        const response = await axios.post('http://127.0.0.1:8001/api/resetpassword',formData);
        console.log(response);
        Swal.fire({
          text: response.data.message,
          icon: "success",
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            navigate("/");
          }});
      }catch(error){
        setErrorMessage(error.response.data.error || "Something went wrong. Please try again.");
      }
    }
   }
  return (
    <div>
      <div className="d-flex justify-content-center align-items-center vh-100">
      <div className="card text-center" style={{ width: "350px" }}>
        <div className="card-header h5 text-white bg-primary">
          Reset password
        </div>
        {errorMessage && <p className="text-danger mt-3">** {errorMessage}</p>}
        <div className="card-body px-5">
          <p className="card-text py-2">
          Enter a new password for your account.
          </p>
          <div className="mb-3 position-relative">
            <input
              type={passwordToggle?"text":"password"}
              className="form-control"
              placeholder="New password"
              onChange={(e) => setPassword(e.target.value)}
            />
            <span
                    className="position-absolute end-0 translate-middle-y me-3 cursor-pointer"
                    style={{ cursor: "pointer", top:"50%" }}
                    onClick={()=>togglePassword("passwordField")}
                  >
                  {passwordToggle?<EyeOff size={20}/>:<Eye size={20}/>}
                  </span>
          </div>

          <div className="mb-3 position-relative">
            <input
              type={confirmPasswordToggle?"text":"password"}
              className="form-control"
              placeholder="Confirm new password"
              onChange={(e) => setConfirmPassword(e.target.value)}
            />
            <span
                    className="position-absolute end-0 translate-middle-y me-3 cursor-pointer"
                    style={{ cursor: "pointer", top:"50%" }}
                    onClick={()=>togglePassword("confirmPasswordField")}
                  >
                  {confirmPasswordToggle?<EyeOff size={20}/>:<Eye size={20}/>}
                  </span>
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
    </div>
  )
}

export default ResetPassword