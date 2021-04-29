<div class="form-group">
    <label>Nivel Categoría</label>
    <select id="parent_id" name="parent_id" class="form-control select2" style="width: 100%;">
        <option value="0" @if(isset($categorydata['parent_id']) && $categorydata['parent_id']==0)
            selected="" @endif>
            Categoría principal
        </option>
        @if(!empty($categories))
            @foreach($categories as $category)
                <option value="{{ $category['id'] }}" @if(isset($categorydata['parent_id']) &&
                            $categorydata['parent_id']==$category['id'])
                selected="" @endif>
                    {{ $category['category_name'] }}
                </option>
                @if(!empty($category['subcategories']))
                    @foreach($category['subcategories'] as $subcategory)
                        <option value="{{ $subcategory['id'] }}">&nbsp;&raquo;&nbsp;{{ $subcategory['category_name'] }}</option>
                    @endforeach
                @endif
            @endforeach
        @endif
    </select>
</div>
