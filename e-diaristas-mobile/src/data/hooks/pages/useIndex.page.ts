import { useState, useMemo } from "react";
import { UserShorInterface } from "data/@types/UserInterface";
import { ValidationService } from "data/services/ValidationService";
import { ApiService } from "data/services/ApiService";

export default function useIndex() {
  // Forma de se declarar diversos useStates
  const [cep, setCep] = useState(""),
    cepValido = useMemo(() => {
      return ValidationService.cep(cep) ? true : false; //"CEP VALIDO" : "CEP INVALIDO";
    }, [cep]),
    [erro, setErro] = useState(""),
    [buscaFeita, setBuscaFeita] = useState(false),
    [carregando, setCarregando] = useState(false),
    [diaristas, setDiaristas] = useState([] as UserShorInterface[]),
    [diaristasRestantes, setDiaristasRestantes] = useState(0);

  async function buscarProfissionais(cep: string) {
    resetarFlagsBuscaProfissionais();

    try {
      const { data } = await ApiService.get<{
        diaristas: UserShorInterface[];
        quantidade_diaristas: number;
      }>(
        // response.data
        "/api/diaristas-cidade?cep=" + cep.replace(/\D/g, "")
      );

      setDiaristas(data.diaristas);
      setDiaristasRestantes(data.quantidade_diaristas);
      setBuscaFeita(true);
      setCarregando(false);
    } catch (err) {
      setErro("CEP não encontrado");
      setCarregando(false);
    }
  }

  function resetarFlagsBuscaProfissionais() {
    setBuscaFeita(false);
    setCarregando(true);
    setErro("");
  }

  return {
    cep,
    setCep,
    cepValido,
    buscarProfissionais,
    erro,
    diaristas,
    buscaFeita,
    carregando,
    diaristasRestantes,
  };
}

/* 
useMemo : esse hook permite a memorização de um processo, tirando a necessidade do React executar sempre!
 Apenas quando necessário. Recebe um segundo param, que é um array com os valores de "dependência", ou seja,
qual valor que sendo alterado chama essa funcionalidade para ser executada novamente
*/
