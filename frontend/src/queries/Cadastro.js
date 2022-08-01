import axios from 'axios'

const pesquisarCep = async (link) => {
  const response = await axios.get(link.url,{method:link.method, withCredentials: false})
  return response.data.status ? response.data.response : false
}

const cadastrarCliente = async (cliente, link) => {
  try{
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json")
    myHeaders.append("Accept","*/*")
  
    const data = JSON.stringify(cliente)
  
    const requestOptions = {
      method: link.method,
      headers: myHeaders,
      body: data,
      mode: 'no-cors'
    };
  
    const response = await axios.post(link.url, {
      data, 
      method:link.method,
      headers:{
        "Content-Type":"application/json",
        "Accept":"*/*",
        "Content-Length":15,
        "Host":"127.0.0.1",
        "User-Agent":"127.0.0.1"
      }
    })
      
    return response.data.status ? response.data.response : false;
  } catch (err) {
    console.log(err);
  }
}

export {
  pesquisarCep,
  cadastrarCliente
}