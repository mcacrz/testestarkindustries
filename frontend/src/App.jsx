import * as React from "react"
import Cadastro from "./pages/Cadastro"
import Clientes from "./pages/Clientes"
import config from '../config.json'
import { cadastrarCliente, pesquisarCep } from "./queries/Cadastro.js"
import {pesquisarCliente} from './queries/Cliente.js'
import { Routes, Route, Link } from "react-router-dom"

const cadastroProps = {
  config,
  query:{
    cadastrarCliente,
    pesquisarCep
  }
}

const clienteProps = {
  config,
  query:{
    pesquisarCliente
  }
}

function App() {
  return (
    <div className="App">
      <Routes>
        <Route path="/" element={<Cadastro {...cadastroProps}/>} />
        <Route path="clientes" element={<Clientes  {...clienteProps}/>} />
      </Routes>
    </div>
  )
}

export default App
