<div>
    <div>
        <div class="row">
            <div class="col-md-3">
                <label for="company">Ristorante</label>
                <select id="company" class="form-control">
                    @foreach ($companies as $company)
                    <option value="{{ $company->id }}"> {{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="from">Dal</label>
                <input type="date" id="from" name="from" class="form-control" />
            </div>
            <div class="col-md-3">
                <label for="to">Al</label>
                <input type="date" id="to" name="to" class="form-control" />
            </div>
            <div class="col-md-3">
                <input type="button" class="btn btn-success" value="Filter" onclick="getData()" />
            </div>
        </div>
    </div>
</div>