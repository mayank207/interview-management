
    <div class="col-md-3">
      <div class="form-group">
          <label class="control-label">{{$items[0]}}</label>
          <div>
        <select name="date" class="form-control">
            <option value="">Select Date</option>
            <option value="7" {{ $oldVals[0]=="7" ? "selected" : "" }}>last 7 days</option>
            <option value="30"{{ $oldVals[0]=="30" ? "selected" : "" }}>this Month</option>
            <option value="60"{{ $oldVals[0]=="60" ? "selected" : "" }}>Last Month</option>
            <option value="90"{{ $oldVals[0]=="90" ? "selected" :  ""}}>Last 3 Month</option>
            <option value="180"{{ $oldVals[0]=="180" ? "selected" : "" }}>Last 6 Month</option>
            <option value="365"{{ $oldVals[0]=="365" ? "selected" : "" }}>full Year</option>
            </select>
          </div>
      </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
          @php
              $technologyFormat =  strtolower(str_replace(' ', '', $items[1]));
          @endphp
          <label class="control-label">{{$items[1]}}</label>
          <div>
              <select name="<?=$technologyFormat?>[]" data-placeholder="Technology" class="select2 form-control" multiple>
                <option value="">Technology</option>
                  @foreach ($technology as $item)
                      <option value="{{$item->id}}" {{isset($oldVals[1]) ?  (collect($oldVals[1])->contains($item['id']))  ? 'selected' : '' : ''}}>{{$item->tech}}</option>
                  @endforeach
              </select>
          </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
          @php
              $stateFormat =  strtolower(str_replace(' ', '', $items[2]));
          @endphp
          <label for="input" class="control-label">{{$items[2]}}</label>
          <div>
              <select name="<?=$stateFormat?>" class="form-control" >
                <option value="">State</option>
                  @foreach ($status as $item)
                  
                      <option value="{{$item->id}}" {{isset($oldVals[2]) ?  (collect($oldVals[2])->
                        contains($item['id']))  ? 'selected' : '' : ''}}>{{ ucfirst(trans($item->status)) }}</option>
                  @endforeach
              </select>
          </div>
        </div>
    </div>
