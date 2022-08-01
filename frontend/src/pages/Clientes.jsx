import React,{useState, useRef} from "react";

function Clientes (props) {
  const [clientes, setClientes] = useState([])
  const [valorPesquisa, setValorPesquisa] = useState('')

  const handleValorPesquisaChange = (event) => setValorPesquisa(event.target.value)

  const handleClick = async () => {
    const typeField = 'cpf'
    const data = valorPesquisa.replace(/\./gi,'').replace('-','')
    const link = {
      url: props.config.api.pesquisaClientes.url.replace('|campo|',typeField).replace('|valor|',data),
      method:props.config.api.pesquisaClientes.method
    }

    const response = await props.query.pesquisarCliente(link);

    (response)
      ? setClientes(response)
      : console.log('Cliente não encontrado')
  }

  return (
    <div>
      <div>
        <input type="text" id="pesquisa" value={valorPesquisa} onChange={handleValorPesquisaChange}></input>
        <button type="button" onClick={handleClick}>Pesquisar</button>
        <div>
          <table>
            <thead>
              <tr>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>CPF</th>
                <th>Risco de Fraude</th>
              </tr>
            </thead>{
              (clientes.length > 0) ? clientes.map(
                (item) => {
                  const [ano, mes, dia] = item.birthday.split('-');
                  return (
                  <tbody key={item.id}>
                    <tr>
                      <td>{item.name}</td>
                      <td>{dia+'/'+mes+'/'+ano}</td>
                      <td>{item.cpf}</td>
                      <td>{(item.hasFraudRisk) ? 'Sim' : 'Não'}</td>
                    </tr>
                  </tbody>
                )}
              ) : null  
            }
          </table>
        </div>
      </div>
    </div>
  )
}

export default Clientes