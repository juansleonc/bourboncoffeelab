import{s as c,t as w}from"./app-core.61d75c0b.js";import{h as i}from"./utils.60c76300.js";import{a as u}from"./icon.6c0bd3d8.js";import{_ as g}from"./vendor-other.2cdd5822.js";import"./vendor-vue-ui.d70c869f.js";import"./vendor-datetime.430013a3.js";import"./vendor-lodash.f9514987.js";const{addFilter:k}=window.wp.hooks,{BlockControls:f}=window.wp.blockEditor,{Button:s,ToolbarGroup:p,ToolbarButton:_}=window.wp.components,{Fragment:$,render:S,unmountComponentAtNode:y}=window.wp.element,{createHigherOrderComponent:x}=window.wp.compose,{select:l,useSelect:h}=window.wp.data,b="all-in-one-seo-pack",d={generateWithAI:g("Generate with AI",b),editWithAI:g("Edit with AI",b)};let I=!1;const m=(a,n={})=>{window.aioseoBus.$emit("do-post-settings-main-tab-change",{name:"aiContent"}),a.classList.add("is-busy"),a.disabled=!0;const e=w(),o=c();setTimeout(()=>{o.initiator=n?.initiator,(!o.initiator||!o.initiator.slug)&&o.resetInitiator(),e.isModalOpened="image-generator",a.classList.remove("is-busy"),a.disabled=!1},500)},q=()=>{c().extend.imageBlockToolbar&&(I||(k("editor.BlockEdit","aioseo/extend-image-block-toolbar",x(n=>e=>{if(e.name!=="core/image"||!e.attributes.url)return i`<${n} ...${e} />`;const o=h(t=>t("core").getEntityRecord("postType","attachment",e.attributes.id)||null,[`media-${e.attributes.id}`]);return i`
				<${$}>
					<${f}>
						<${p}>
							<${_}
								icon=${u}
								iconSize=${24}
								label=${d.editWithAI}
								onClick=${t=>{m(t.currentTarget,{initiator:{slug:"image-block-toolbar",wpMedia:o}})}}
								style=${{maxHeight:"90%",alignSelf:"center",padding:"0"}}
							/>
						</${p}>
					</${f}>

					<${n} ...${e} />
				</${$}>`},"extendImageBlockToolbar")),I=!0))},L=()=>{if(!c().extend.imageBlockPlaceholder)return;const n=l("core/block-editor").getSelectedBlock();if(!n||n.name!=="core/image"||n.attributes?.url)return;const e=document.getElementById(`block-${n.clientId}`),o=e?.querySelector(".components-form-file-upload");if(!o||e?.querySelector(".aioseo-ai-image-generator-btn"))return;const t=document.createElement("div");S(i`
			<${s}
				className=${"aioseo-ai-image-generator-btn"}
				variant=${"secondary"}
				icon=${u}
				iconSize=${"20"}
				__next40pxDefaultSize=${!0}
			>
				${d.generateWithAI}
			</${s}>`,t);const r=t.firstChild?.cloneNode(!0);r&&(o.after(r),r.addEventListener("click",()=>{m(r,{initiator:{slug:"image-block-placeholder"}})})),y(t),t.remove()},N=()=>{if(!c().extend.featuredImageButton||l("core/edit-post").getActiveGeneralSidebarName()!=="edit-post/document")return;if(l("core/editor").getEditedPostAttribute("featured_media")){document.querySelector(".aioseo-ai-image-generator-btn-featured-image")?.remove();return}setTimeout(()=>{const e=document.querySelector(".editor-post-featured-image__container"),o=e?.querySelector("button");if(!o||e?.querySelector(".aioseo-ai-image-generator-btn-featured-image"))return;e.style.display="flex",e.style.gap="8px";const t=document.createElement("div");S(i`
				<${s}
					className=${"aioseo-ai-image-generator-btn-featured-image"}
					variant=${"secondary"}
					icon=${u}
					iconSize=${"20"}
					__next40pxDefaultSize=${!0}
					title=${d.generateWithAI}
				/>`,t);const r=t.firstChild?.cloneNode(!0);r&&(o.after(r),r.addEventListener("click",()=>{m(r,{initiator:{slug:"featured-image-btn"}})})),y(t),t.remove()})};export{N as extendFeaturedImageButton,L as extendImageBlockPlaceholder,q as extendImageBlockToolbar};
