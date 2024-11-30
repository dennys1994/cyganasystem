import tkinter as tk
from tkinter import ttk

# Tabela de coeficientes (ajustados por faixa de preço)
faixas_precos_produtos = [
    {"min": 0, "max": 100, "avista": 0.55, "parcelado": 0.9},
    {"min": 100, "max": 200, "avista": 0.65, "parcelado": 0.9},
    {"min": 200, "max": 1000, "avista": 0.7, "parcelado": 0.9},
    {"min": 1000, "max": 3000, "avista": 0.75, "parcelado": 0.9},
    {"min": 3000, "max": float('inf'), "avista": 0.8, "parcelado": 0.9},
]

faixas_precos_trocatela = [
    {"min": 0, "max": 200, "avista": 0.55, "parcelado": 0.9},
    {"min": 200, "max": 300, "avista": 0.58, "parcelado": 0.9},
    {"min": 300, "max": 400, "avista": 0.62, "parcelado": 0.9},
    {"min": 400, "max": 500, "avista": 0.66, "parcelado": 0.9},
    {"min": 500, "max": float('inf'), "avista": 0.7, "parcelado": 0.9},
]

faixas_precos_produtos = [
    {"min": 0, "max": 100, "avista": 0.55, "parcelado": 0.9},
    {"min": 100, "max": 200, "avista": 0.65, "parcelado": 0.9},
    {"min": 200, "max": 1000, "avista": 0.7, "parcelado": 0.9},
    {"min": 1000, "max": 3000, "avista": 0.75, "parcelado": 0.9},
    {"min": 3000, "max": float('inf'), "avista": 0.8, "parcelado": 0.9},
]

faixas_precos_produtos = [
    {"min": 0, "max": 100, "avista": 0.55, "parcelado": 0.9},
    {"min": 100, "max": 200, "avista": 0.65, "parcelado": 0.9},
    {"min": 200, "max": 1000, "avista": 0.7, "parcelado": 0.9},
    {"min": 1000, "max": 3000, "avista": 0.75, "parcelado": 0.9},
    {"min": 3000, "max": float('inf'), "avista": 0.8, "parcelado": 0.9},
]


def calcular():
    try:
        categoria = combo_categoria.get()
        custo = float(entry_custo.get())
        frete = float(entry_frete.get())

        # Validações
        if categoria == "Produtos":
            for faixa in faixas_precos_produtos:
                if faixa["min"] <= custo < faixa["max"]:
                    avista = ((custo / faixa["avista"] ) + frete)
                    parcelado = avista / faixa["parcelado"]
                    margem = (avista - (frete+custo) -(0.03 * avista))
                    margem2 = ((custo/(custo+margem))-1)*-100


                    # Exibindo os resultados
                    label_avista_valor['text'] = f"Venda à Vista: R$ {avista:.2f}"
                    label_parcelado_valor['text'] = f"Venda Parcelado: R$ {parcelado:.2f}"
                    label_margem_valor['text'] = f"Margem: R$ {margem: .2f} | {margem2:.2f} % "
                    return

            label_avista_valor['text'] = "Erro: Preço fora das faixas!"
        else:
            label_avista_valor['text'] = "Categoria não implementada ainda!"
    except ValueError:
        label_avista_valor['text'] = "Erro: Insira valores válidos!"
        label_parcelado_valor['text'] = ""
        label_margem_valor['text'] = ""

# Interface gráfica
janela = tk.Tk()
janela.title("Calculadora de Margem de Venda")

# Seleção de Categoria
tk.Label(janela, text="Categoria:").grid(row=0, column=0, sticky="w")
combo_categoria = ttk.Combobox(janela, values=["Produtos", "Troca de Tela", "Troca de Bateria", "Troca de Tampa"])
combo_categoria.grid(row=0, column=1)
combo_categoria.set("Produtos")

# Entradas
tk.Label(janela, text="Preço de Custo (R$):").grid(row=1, column=0, sticky="w")
entry_custo = tk.Entry(janela)
entry_custo.grid(row=1, column=1)

# Entrada de Frete com valor padrão de 0
tk.Label(janela, text="Frete (R$):").grid(row=2, column=0, sticky="w")
frete_var = tk.StringVar(value="0")  # Define o valor padrão como "0"
entry_frete = tk.Entry(janela, textvariable=frete_var)  # Associa ao campo
entry_frete.grid(row=2, column=1)


# Botão Calcular
btn_calcular = tk.Button(janela, text="Calcular", command=calcular)
btn_calcular.grid(row=3, columnspan=2)

# Resultados
label_avista_valor = tk.Label(janela, text="")
label_avista_valor.grid(row=4, columnspan=2)

label_parcelado_valor = tk.Label(janela, text="")
label_parcelado_valor.grid(row=5, columnspan=2)

label_margem_valor = tk.Label(janela, text="")
label_margem_valor.grid(row=6, columnspan=2)

# Inicia o programa
janela.mainloop()
