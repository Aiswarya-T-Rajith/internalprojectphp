import './App.css';
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Login from './pages/Login';
import ForgotPassword from './pages/ForgotPassword';
import ResetPassword from './pages/ResetPassword';

function App() {
  return (
    <div className="App">
      <Router>
            <Routes>
                <Route path="/" element={<Login />} />
                <Route path="/forgotpassword" element={<ForgotPassword/>}/>
                <Route path="/resetpassword" element={<ResetPassword/>}/>
            </Routes>
        </Router>
    </div>
  );
}

export default App;
