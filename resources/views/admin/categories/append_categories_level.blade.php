<div class="form-group">
    <label>Nivel Categoría</label>
    <select id="parent_id" name="parent_id" class="form-control select2" style="width: 100%;">
        <option value="0">Categoría principal</option>
        @if(!empty($categories))
            @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['category_name'] }}</option>
                @if(!empty($category['subcategories']))
                    @foreach($category['subcategories'] as $subcategory)
                        <option value="{{ $subcategory['id'] }}">&nbsp;&raquo;&nbsp;{{ $subcategory['category_name'] }}</option>
                    @endforeach
                @endif
            @endforeach
        @endif
    </select>
</div>
