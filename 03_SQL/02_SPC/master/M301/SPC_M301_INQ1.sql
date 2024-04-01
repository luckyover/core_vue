IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M301_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M301_INQ1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M301_INQ1 '','',0, 0, 0,'809','M101','172.19.0.1';
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Get detail of m_process_price
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	ThuanNV - ANS909
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE [dbo].[SPC_M301_INQ1]
	@P_item_cd						NVARCHAR(30)	= N''
,	@P_item_nm						NVARCHAR(50)	= N''
,	@P_category_div					SMALLINT		= 0
,	@P_material_div					SMALLINT		= 0
,	@P_processing_place_div			SMALLINT		= 0
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SET @P_item_cd = ISNULL(@P_item_cd, N'')
	SET @P_item_nm = ISNULL(@P_item_nm, N'')

	SELECT
		M301.item_cd
	,	MAX(M101.item_nm)			AS item_nm
	,	M301.category_div
	,	M301.material_div
	,	M301.processing_place_div
	,	M301.number_sheet_fr
	,	M301.number_sheet_to
	,	M301.color_div
	,	M301.sales_amt
	FROM M301						WITH(NOLOCK)
	LEFT JOIN M101					WITH(NOLOCK)	ON (
		M301.item_cd				= M101.item_cd		
	) 
	WHERE (
		@P_item_cd					= N''
	OR	M301.item_cd				= @P_item_cd
	)
	AND (
		@P_item_nm					= N''			
	OR	M101.item_nm				LIKE '%' + @P_item_nm + '%'
	)
	AND (
		@P_category_div	= 0			
	OR M301.category_div			= @P_category_div
	)
	AND (
		@P_material_div = 0			
	OR M301.material_div			= @P_material_div
	)
	AND (
		@P_processing_place_div		= 0 
	OR M301.processing_place_div	= @P_processing_place_div
	)
	--AND M101.item_class_div		=  2
	AND M301.del_flg				<> 1
	GROUP BY
		M301.item_cd
	,	M301.category_div
	,	M301.material_div
	,	M301.processing_place_div
	,	M301.number_sheet_fr
	,	M301.number_sheet_to
	,	M301.color_div
	,	M301.sales_amt
END
