<form action="{{ route('bandeiras.update', $bandeira->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="nome" value="{{ $bandeira->nome }}">
    <button type="submit">Atualizar</button>
</form>
