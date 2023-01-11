<div class="form-group">
    <label for="timee" class="">Temps * </label>
    <input class="form-control" type="datetime-local" name="timee" id="timee" value="{{ $temperature->time ?? null }}" >
</div>

<div class="form-group">
    <label for="temperature" class="">Temperature *</label>
    <input class="form-control" type="number" name="temperature" id="temperature" value="{{ $temperature->temperature ?? null }}" step="any">
</div>

<div class="form-group">
    <a class="btn btn-danger mr-1" href='{{ route("temperatures.index") }}' type="submit">Annuler</a>
    <button class="btn btn-success save" type="submit">{{ $text_btn }}</button>
</div>

