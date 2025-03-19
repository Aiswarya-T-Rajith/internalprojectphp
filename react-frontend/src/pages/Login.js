import React, { useState } from "react";
import "../style/login.css";
import "bootstrap/dist/css/bootstrap.min.css";
import loginImage from "../assets/login.jpg";
import axios from "axios";
import { Eye, EyeOff } from "lucide-react";
import { useNavigate } from "react-router-dom";

function Login() {
    const[email, setEmail] = useState("");
    const[password, setPassword] = useState("");
    const [errors, setErrors] = useState({});
    const [passwordToggle,setPasswordToggle] = useState(false);
    const navigate = useNavigate();

    const togglePassword=()=>{
        setPasswordToggle((prev)=>!prev);
    }

    const validateForm = () => {
        let validationErrors = {};
    
        // Email validation
        if (!email.trim()) {
          validationErrors.email = "Email is required.";
          console.log("true");
        } else if (!/\S+@\S+\.\S+/.test(email)) {
          validationErrors.email = "Invalid email format.";
          console.log("Error");
        }
    
        // Password validation
        if (!password.trim()) {
            validationErrors.password = "Password is required.";
        } else if (password.length < 6) {
            validationErrors.password = "Password must be at least 6 characters long.";
        } else if (/\s/.test(password)) {
            validationErrors.password = "Password must not contain spaces.";
        } else if (!/[A-Z]/.test(password)) {
            validationErrors.password = "Password must contain at least one uppercase letter.";
        } else if (!/[a-z]/.test(password)) {
            validationErrors.password = "Password must contain at least one lowercase letter.";
        } else if (!/[0-9]/.test(password)) {
            validationErrors.password = "Password must contain at least one number.";
        } else if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            validationErrors.password = "Password must contain at least one special character.";
        }
    
        setErrors(validationErrors);
        console.log("Validation Errors:", validationErrors);
        return Object.keys(validationErrors).length === 0;
      };
    
      const handleSubmit = async(e) => {
        e.preventDefault();
        if (validateForm()) {
            try {
                const response = await axios.post("http://localhost:8001/api/login", {
                    email,
                    password
                });

                console.log("Login Successful:", response.data.user.role);
                localStorage.setItem("token", response.data.token);
                localStorage.setItem("UserRole",response.data.user.role);
    
                if(response.data.user.role === "superadmin"){
                  navigate("/")
                }
                // Redirect user or update UI
                alert("Login successful!");
    
            } catch (error) {
                // Handle error response
                if (error.response) {
                    console.error("Login Error:", error.response.data);
                    setErrors({ api: error.response.data.message || "Login failed. Please try again." });
                } else {
                    console.error("Login Error:", error.message);
                    setErrors({ api: "An error occurred. Please try again later." });
                }
            }
          
        }
      };

  return (
    <div>
      <div className="d-flex justify-content-center align-items-center vh-100">
        <section className="p-3 p-md-4 p-xl-5 w-60 shadow-lg rounded bg-white w-75 h-75">
          <div className="container h-100">
            <div className="card border-light-subtle shadow-sm h-100">
              <div className="row g-0 h-100">
                <div className="col-12 col-md-6 h-100">
                  <img
                    className="img-fluid rounded-start w-100 h-100 object-fit-cover"
                    loading="lazy"
                    src={loginImage}
                    alt="login"
                  />
                </div>
                <div className="col-12 col-md-6 h-100">
                  <div className="card-body p-3 p-md-4 p-xl-5 h-100">
                    <div className="row">
                      <div className="col-12">
                        <div className="mb-5">
                          <h3>Log in</h3>
                        </div>
                      </div>
                    </div>
                    <div className="flex-grow-1">
                      <form onSubmit={handleSubmit}>
                        <div className="row gy-3 gy-md-4 overflow-hidden">
                          <div className="col-12">
                            <label
                              for="email"
                              className="form-label text-start d-block"
                            >
                              Email <span className="text-danger">*</span>
                            </label>
                            <input
                              type="email"
                              className={`form-control ${errors.email ? "is-invalid" : ""}`}
                              name="email"
                              id="email"
                              placeholder="name@example.com"
                              value={email}
                              onChange={(e) => setEmail(e.target.value)}
                              required
                            />
                            {errors.email && <div className="text-danger mt-1">{errors.email}</div>}
                          </div>
                          <div className="col-12">
                            <label
                              for="password"
                              className="form-label text-start d-block"
                            >
                              Password <span className="text-danger">*</span>
                            </label>
                            <div className="mb-3 position-relative">
                            <input
                              type={passwordToggle?"text":"password"}
                              className={`form-control ${errors.password ? "is-invalid" : ""}`}
                              name="password"
                              id="password"
                              value={password}
                              onChange={(e) => setPassword(e.target.value)}
                              required
                            />
                            <span
                              className="position-absolute end-0 translate-middle-y me-3 cursor-pointer"
                              style={{ cursor: "pointer", top:"50%" }}
                              onClick={()=>togglePassword()}
                            >
                            {passwordToggle?<EyeOff size={20}/>:<Eye size={20}/>}
                            </span>
                            </div>
                            {errors.password && <div className="text-danger mt-1">{errors.password}</div>}
                          </div>
                          <div className="col-12">
                            <div className="form-check d-flex align-items-center gap-2">
                              <input
                                className="form-check-input"
                                type="checkbox"
                                value=""
                                name="remember_me"
                                id="remember_me"
                              />
                              <label
                                className="form-check-label text-secondary"
                                for="remember_me"
                              >
                                Keep me logged in
                              </label>
                            </div>
                          </div>
                          <div className="col-12">
                            <div className="d-grid">
                              <button
                                className="btn bsb-btn-xl btn-primary"
                                type="submit"
                              >
                                Log in now
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                      <div className="row h-100">
                        <div className="col-12 h-100">
                          <div className="justify-content-md-center">
                            <a
                              href="/forgotpassword"
                              className="link-secondary text-decoration-none"
                            >
                              Forgot password
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  );
}

export default Login;
