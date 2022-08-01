import axios from 'axios'

const pesquisarCliente = async (link) => {
  const response = await axios.get(link.url,{method:link.method, withCredentials: false})
  return response.data.status ? response.data.response : false
}

export {
  pesquisarCliente
}