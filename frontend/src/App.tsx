import { useEffect, useState } from "react";
import { Spinner } from "./components/Spinner/Spinner.tsx";
import { UrlList } from "./components/UrlList/UrlList.tsx";

function App() {
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [verified, setVerified] = useState<boolean>(false);

  async function createSession() {
      setIsLoading(true);

      await fetch('https://localhost/api/session/', {
          method: "POST"
      })
          .then(res => res.json())
          .then(data => {
              if (data.token) {
                  localStorage.setItem('token', data.token);
                  setVerified(true);
                  setIsLoading(false);
              }
          })
  }

  async function getSession() {
      setIsLoading(true);

      const token = localStorage.getItem('token');

      await fetch('https://localhost/api/session', {
          headers: {
              Authorization: `Bearer ${token}`
          }
      })
          .then(res => {
              if (res.status === 401) {
                  createSession();
                  return null;
              }

              return res.json();
          })
          .then(data => {
              if (data !== null) {
                  console.log(data);
              }

              setVerified(true);
          })
          .finally(() => setIsLoading(false))
  }

  useEffect(() => {
    getSession();
  }, []);

  return (
    <>
        <Spinner visible={isLoading} />

        {
            <UrlList />
        }
    </>
  )
}

export default App
