const HELPER = (function(){

	let thisHelper = {};

	thisHelper.sampleHelper = function()
	{
		console.log('helper');
	}

	thisHelper.numberWithCommas = function(x)
	{
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
	}
	
	return thisHelper;

})();