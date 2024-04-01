IF  EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[SPC_M201_INQ1]') AND type in (N'P', N'PC'))
DROP PROCEDURE SPC_M201_INQ1
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
-- EXEC SPC_M201_INQ1 '','','','0','902','M201','172.18.0.1';
--****************************************************************************************
--*   											
--*  処理概要/process overview	:	Get detail of product
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	QuanLH - ANS902
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE SPC_M201_INQ1
	@P_item_cd						NVARCHAR(30)	= N''
,	@P_color_cd						NVARCHAR(10)	= N''
,	@P_item_nm						NVARCHAR(255)	= N''
,	@P_price_list					SMALLINT		= 0
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	SET @P_color_cd = ISNULL(@P_color_cd, N'')
	SELECT
		M201.item_cd
	,	M201.color_cd
	,	MAX(M101.item_nm)			AS item_nm
	,	MAX(M101.color_nm)			AS color_nm
	,	M201.size_cd
	,	M201.price_list
	,	M201.retail_upr
	FROM M201 WITH(NOLOCK)
	LEFT JOIN M101 WITH(NOLOCK) ON 
    ( 
        M201.item_cd				= M101.item_cd	
	AND	M201.color_cd				= M101.color_cd
    )
	WHERE (
			@P_item_cd = N'' 
		OR M201.item_cd = @P_item_cd
	) 
    AND (
			@P_color_cd = N'' 
		OR M201.color_cd = @P_color_cd
	) 
    AND (
			@P_item_nm = N'' 
		OR M101.item_nm LIKE '%' + @P_item_nm + '%'			 					
	) 
	AND (
			@P_price_list = 0
		OR M201.price_list = @P_price_list
	) 
	--AND M101.item_class_div			<> 2
	AND M101.del_flg				<> 1
	AND M201.del_flg				<> 1
	GROUP BY
		M201.item_cd
	,	M201.color_cd
	,	M201.size_cd
	,	M201.price_list
	,	M201.retail_upr
END
GO
