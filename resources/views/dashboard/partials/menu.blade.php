<section id="page-menu">
	<h3 class="md-headline">Site Menu</h3>
    <md-list>

    	<md-content class="md-padding">
    		<div layout layout-sm="column">
		    	<div flex="50">
		    		<div class="md-cus-panel">
		    			<header class="md-cus-header">
		    				<span class="md-cus-linker" ng-click="selectChain('main')">Main Menu</span>
		    				<span ng-repeat="current in chains"
		    					class="md-cus-chain-menu">
		    					<span class="icon-arrow-right2"></span>
		    					<span class="linker" ng-click="selectChain(current)"><% current.display_name %></span>
		    				</span>
		    			</header>
		    			<article class="md-cus-content"  
		    				layout 
		    				layout-align="center center">
		    				<ul class="md-cus-draggable-list" 
		    					ng-if="tabs.length" 
		    					dnd-list="tabs">
		    					<li ng-repeat="menu in tabs"
		    						dnd-draggable="menu"
		    						md-ink-ripple
							        dnd-moved="tabs.splice($index, 1); updateMenuSeqNumber();"
							        dnd-effect-allowed="move"
							        dnd-selected="models.selected = menu"
							        fake-ng-class="{'selected': models.selected === menu}"
							        ng-click="viewMenu(menu)">
		    						<span class="handle">
		    							<span class="icon-menu"></span>
		    						</span>
		    						<label><% menu.display_name %></label>
		    					</li>
		    				</ul>
		    				<md-content class="md-padding" ng-if="!tabs.length" >
		    					<div class="">There is no menu here.</div>
		    				</md-content>
		    			</article>
		    		</div>
		    	</div>
		    	<div flex="50" layout-padding="16" 
		    		layout="row" 
		    		layout-align="center center"
		    		class="hint-menu-draggable">
			        <p>
			        	Click on each item to move inside to see its sub menu. Drag that item up or down to move its sequence number.
				        <span ng-show="current">
				        	<br/>
				        	<br/>
				        	You have selected <b><% current.display_name %></b>.
				        	<br/>
				        	<b>Url:</b> /<% current.name || '#'%>
				        	<br/>
				        	<b>Description:</b> <% current.description %>
				        	<br/>
				        	To remove or edit click below:
				        	<br/>
				        	<md-button ng-click="removeMenu(current, $event)" class="md-raised">Remove</md-button>

				        	<md-button 
				        		ng-click="editMenu(current, $event)" 
				        		class="md-raised">Edit</md-button>
				        </span>
				        <span ng-show="current && !current.items.length">
				        	<br/><br/>
				        	Look like there is no sub menu here. You can create one by clicking the below red button!
				        </span>
			        </p>
		    	</div>
	    	</div>
	 	</md-content>
        <md-content layout-padding="16">
      		<md-fab-speed-dial md-open="false" md-direction="up">
		        <md-fab-trigger>
		          	<md-button aria-label="menu" class="md-fab md-warn">
		            	<md-icon md-font-icon="icon-plus"></md-icon>
		          	</md-button>
		        </md-fab-trigger>
	        	<md-fab-actions>
	          		<md-button aria-label="menu-item" 
		          		ng-click="createMenu(current, $event)"
		          		class="md-fab md-raised md-mini">
	            		<md-icon md-font-icon="icon-menu"></md-icon>
	          		</md-button>
        		</md-fab-actions>
	      	</md-fab-speed-dial>
        </md-content>
    </md-list>
</section>