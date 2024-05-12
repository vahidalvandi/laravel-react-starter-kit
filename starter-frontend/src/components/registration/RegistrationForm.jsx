import React, { useState } from "react";
import { Link } from "react-router-dom";
import { Card, Input, Button, Typography } from "@material-tailwind/react";

function RegistrationForm() {
  const [username, setUsername] = useState("");
  const [user_email, setUserEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleSignup = (e) => {
    e.preventDefault();
    console.log("I am here....");
    console.log(username);
    console.log(user_email);
    console.log(password);
  };

  return (
    <>
      <div className="bg-gray-200 flex justify-center items-center h-screen">
        <div className="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
          <Card color="transparent" shadow={false}>
            <Typography variant="h4" color="blue-gray">
              Sign Up
            </Typography>
            <Typography color="gray" className="mt-1 font-normal">
              Nice to meet you! Enter your details to register.
            </Typography>
            <form
              className="mt-8 mb-2 w-80 max-w-screen-lg sm:w-96"
              onSubmit={handleSignup}
            >
              <div className="mb-1 flex flex-col gap-6">
                <Typography variant="h6" color="blue-gray" className="-mb-3">
                  Your Name
                </Typography>
                <Input
                  size="lg"
                  placeholder="name"
                  className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                  labelProps={{
                    className: "before:content-none after:content-none",
                  }}
                  value={username}
                  onChange={(e) => setUsername(e.target.value)}
                />
                <Typography variant="h6" color="blue-gray" className="-mb-3">
                  Your Email
                </Typography>
                <Input
                  type="email"
                  size="lg"
                  placeholder="name@mail.com"
                  className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                  labelProps={{
                    className: "before:content-none after:content-none",
                  }}
                  value={user_email}
                  onChange={(e) => setUserEmail(e.target.value)}
                />
                <Typography variant="h6" color="blue-gray" className="-mb-3">
                  Password
                </Typography>
                <Input
                  type="password"
                  size="lg"
                  placeholder="********"
                  className=" !border-t-blue-gray-200 focus:!border-t-gray-900"
                  labelProps={{
                    className: "before:content-none after:content-none",
                  }}
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                />
              </div>
              <Button type="submit" className="mt-6" fullWidth>
                sign up
              </Button>
              <Typography color="gray" className="mt-4 text-center font-normal">
                Already have an account?{" "}
                <Link to="/" className="font-medium text-gray-900">
                  Sign In
                </Link>
              </Typography>
            </form>
          </Card>
        </div>
      </div>
    </>
  );
}

export default RegistrationForm;
