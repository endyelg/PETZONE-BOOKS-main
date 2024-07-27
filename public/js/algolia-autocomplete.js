(function(){
    var client = algoliasearch('PYK3LQW0S1', '056f3f57cd7da44437eceab4a03e28d4');
    var index = client.initIndex('products');
    console.log(index);
    autocomplete('#aa-search-input',
        {hint:false}, {
            source: autocomplete.sources.hits(index, {hitsPerPage: 10}),
            displayKey: 'title',
            templates:{
                suggestion: function(suggestion) {
                    console.log(suggestion);
                    return '<span>' +
                        suggestion._highlightResult.title.value + '</span><span>' +
                        suggestion.price + '</span>';
                }
            }
        }
    )
})();
