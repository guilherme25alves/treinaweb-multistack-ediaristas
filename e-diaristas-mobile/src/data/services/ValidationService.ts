export const ValidationService = {
  cep(cep = ""): boolean {
    return cep.replace(/\D/g, "").length === 8;
  },
};

/*
   return cep.replace(/\D/g, "").length === 8;

   Regex : 
     / / : começo e fim da Regex;
     \D : busca por valores que não seja dígito númerico
     g :  significa "global" : para buscar por todos os elementos, sem o g ele encontraria apenas a primeira ocorrência 
*/

// Exemplo de CEP que possui valores : 01001000
