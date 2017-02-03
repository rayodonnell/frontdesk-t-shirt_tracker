<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title " data-group="{{group}}">{{name}} <span class="totalCount">- {{totalcount}}</span></h3>
	</div>
	<div class="panel-body {{visible}}">
		{{#each this.blobs}}
			<div class="col-lg-3 col-sm-6">
				<div class="circle {{checkDisabled maxtotal type counttotal}}" data-title="{{name}}" data-fid="{{id}}" data-group="{{group}}" data-print="{{print}}" data-print2="{{print2}}">{{name}}</div>
				<div class="count">{{math maxtotal type counttotal}} </div>
			</div>
		{{/each}}
	</div>
</div>