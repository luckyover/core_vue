IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M302_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M302_INQ1
GO
/****** Object:  StoredProcedure [dbo].[SPC_M302_INQ1]    Script Date: 2/22/2024 11:48:32 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
--EXEC SPC_M302_INQ1 '','','','',0, 0, 0,'809','M101','172.19.0.1';
--****************************************************************************************
--*  											
--*  処理概要/process overview	:	Get detail of delivery
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	DungNT - ANS907
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content	:   
--****************************************************************************************
CREATE PROCEDURE SPC_M302_INQ1
	@P_supplier_cd								NVARCHAR(30)	= N''
,	@P_supplier_nm								NVARCHAR(50)	= N''
,	@P_item_cd									NVARCHAR(30)	= N''
,	@P_item_nm									NVARCHAR(50)	= N''
,	@P_category_div								SMALLINT		= 0
,	@P_material_div								SMALLINT		= 0
,	@P_processing_place_div						SMALLINT		= 0
,	@P_act_user_cd								NVARCHAR(10)	= N''
,	@P_prg										NVARCHAR(30)	= N''
,	@P_ip										NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SET @P_supplier_cd							= ISNULL(@P_supplier_cd, N'')
	SET @P_supplier_nm							= ISNULL(@P_supplier_nm, N'')
	SET @P_item_cd								= ISNULL(@P_item_cd, N'')
	SET @P_item_nm								= ISNULL(@P_item_nm, N'')
	SELECT
		M302.supplier_cd
	,	MAX(M006.supplier_nm)					AS supplier_nm
	,	M302.item_cd
	,	MAX(M101.item_nm)						AS item_nm
	,	M302.category_div
	,	M302.material_div
	,	M302.processing_place_div
	,	FORMAT(M302.number_sheet_fr, '#,0')		AS number_sheet_fr
	,	FORMAT(M302.number_sheet_to, '#,0')		AS number_sheet_to
	,	M302.color_div
	,	FORMAT(M302.sales_amt, '#,0')			AS sales_amt
	FROM M302									WITH(NOLOCK)
	LEFT JOIN M101														WITH(NOLOCK)	ON (
		M302.item_cd							= M101.item_cd		
	) 
	LEFT JOIN M006														WITH(NOLOCK)	ON (
		M302.supplier_cd						= M006.supplier_cd		
	)
	WHERE(
		@P_supplier_cd							= N''
	OR	M302.supplier_cd						= @P_supplier_cd
	)
	AND (
		@P_supplier_nm							= N''
	OR	M006.supplier_nm						LIKE '%' + @P_supplier_nm + '%'
	)
    AND(
	    @P_item_cd								= N''		
	OR	M302.item_cd							= @P_item_cd
	)
	AND (
		@P_item_nm								= N''		
	OR	M101.item_nm							LIKE '%' + @P_item_nm + '%'
	)
	AND (
		@P_category_div							= 0			
	OR	M302.category_div						= @P_category_div
	)
	AND (
		@P_material_div							= 0			
	OR	M302.material_div						= @P_material_div
	)
	AND (
		@P_processing_place_div					= 0 
	OR	M302.processing_place_div				= @P_processing_place_div
	)
	--AND M101.item_class_div						=  2
	AND M101.del_flg							<> 1
	AND M302.del_flg							<> 1
	GROUP BY
		M302.supplier_cd
	,	M302.item_cd
	,	M302.category_div
	,	M302.material_div
	,	M302.processing_place_div
	,	M302.number_sheet_fr
	,	M302.number_sheet_to
	,	M302.color_div
	,	M302.sales_amt
END
GO
