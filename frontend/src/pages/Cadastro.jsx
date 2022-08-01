import React,{useState} from "react";

function Cadastro (props) {
  /**
   * variáveis de estado
   */
  const [nome, setNome] = useState('')
  const [dataNascimento, setDataNascimento] = useState('')
  const [rg, setRg] = useState('')
  const [cpf, setCpf] = useState('')
  const [cep, setCep] = useState('')
  const [logradouro, setLogradouro] = useState('')
  const [numero, setNumero] = useState('')
  const [bairro, setBairro] = useState('')
  const [cidade, setCidade] = useState('')
  const [uf, setUf] = useState('')
  const [foto, setFoto] = useState('')

  /**
   * métodos locais
   */
  const preencheEndereco = (endereco) => {
    setLogradouro(endereco.logradouro)
    setBairro(endereco.bairro)
    setCidade(endereco.localidade)
    setUf(endereco.uf)
  }

  const buscarCep = async (event) => {
    if (event.target.value.length === 9) {
      const cepParam = event.target.value.replace('-','')

      const link = {
        url:props.config.api.pesquisaCep.url.replace('|cep|',cepParam),
        method:props.config.api.pesquisaCep.method
      }
      const endereco = await props.query.pesquisarCep(link);
      if (endereco) preencheEndereco(endereco)

      return true
    }
  }

  const handleNomeChange = (event) => setNome(event.target.value)
  const handleNascimentoChange = (event) => setDataNascimento(event.target.value)
  const handleRgChange = (event) => setRg(event.target.value)
  const handleCpfChange = (event) => setCpf(event.target.value)
  const handleCepChange = async (event) => setCep(event.target.value)
  const handleLogradouroChange = (event) => setLogradouro(event.target.value)
  const handleNumeroChange = (event) => setNumero(event.target.value)
  const handleBairroChange = (event) => setBairro(event.target.value)
  const handleCidadeChange = (event) => setCidade(event.target.value)
  const handleUfChange = (event) => setUf(event.target.value)
  const handleFotoChange = (event) => {
    const file = event.target.files
    const reader = new FileReader()
    reader.readAsDataURL(file[0])
    reader.onloadend = () => {
      const img = reader.result
      setFoto(img.replace(/data:image\/(.*), ?/, ""))
    }
  }

  const handleClick = async (event) => {
    const data = {
      nome,
      dataNascimento,
      cpf,
      rg,
      cep:cep.replace('-',''),
      logradouro,
      numero,
      bairro,
      cidade,
      uf,
      foto
    }

    const response = await props.query.cadastrarCliente(data,props.config.api.inserirClientes);

    (!response)
      ? console.log('Não foi possível cadastrar o cliente')
      : console.log('Cadastro realizado com sucesso')
  }

  return (
    <div>
      <form>
        <div><input type="text" id="nome" value={nome} placeholder="Digite o nome" onChange={handleNomeChange}></input></div>
        <div><input type="text" id="datanascimento" value={dataNascimento} placeholder="Digite a data de nascimento" onChange={handleNascimentoChange}></input></div>
        <div><input type="text" id="rg" value={rg} placeholder="Digite o rg" onChange={handleRgChange}></input></div>
        <div><input type="text" id="cpf" value={cpf} placeholder="Digite o cpf" onChange={handleCpfChange}></input></div>
        <div><input type="text" id="cep" value={cep} placeholder="Digite o cep" onKeyUp={buscarCep} onChange={handleCepChange}></input></div>
        <div><input type="text" id="logradouro" value={logradouro} placeholder="Digite o logradouro" onChange={handleLogradouroChange}></input></div>
        <div><input type="text" id="numero" value={numero} placeholder="Digite o número" onChange={handleNumeroChange}></input></div>
        <div><input type="text" id="bairro" value={bairro} placeholder="Digite o bairro" onChange={handleBairroChange}></input></div>
        <div><input type="text" id="cidade" value={cidade} placeholder="Digite a cidade" onChange={handleCidadeChange}></input></div>
        <div><input type="text" id="uf" value={uf} placeholder="Digite a uf" onChange={handleUfChange}></input></div>
        <div><input type="file" id="foto" onChange={handleFotoChange}></input></div>
        <button type="button" onClick={handleClick}>Enviar</button>
      </form>
    </div>
  )
}

export default Cadastro 