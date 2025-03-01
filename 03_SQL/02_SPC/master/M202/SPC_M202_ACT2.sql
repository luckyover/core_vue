SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- +--TEST--+
--
--****************************************************************************************
--* 											
--*  処理概要/process overview	:	Delete data of a product cost
--*  
--*  作成日/create date			:	2024/02/22
--*　作成者/creater				:	HaiNN - ANS901
--*   					
--*  更新日/update date			:   
--*　更新者/updater				:   
--*　更新内容/update content		:   
--****************************************************************************************
CREATE PROCEDURE [dbo].[SPC_M202_ACT2]
	@P_costs						NVARCHAR(MAX)	= N''
,	@P_act_user_cd					NVARCHAR(10)	= N''
,	@P_prg							NVARCHAR(30)	= N''
,	@P_ip							NVARCHAR(20)	= N''
AS
BEGIN
	SET NOCOUNT ON;
	DECLARE 
	-- variable general
		@w_time						DATETIME2		=	SYSDATETIME()
	,	@ERR_TBL					ERRTABLE
	-- variable log
    ,   @w_prs_mode					NVARCHAR(200)   =   N'Delete'
    ,   @w_prs_result				NVARCHAR(200)   =   N'OK'
	,	@w_remarks					NVARCHAR(200)	=	N''
	,	@w_table_key				NVARCHAR(200)	=	N''

	-- create temp tables 
	CREATE TABLE #TMP_PRODUCT_COST_DELETE (
		item_cd							NVARCHAR(30)
	,	color_cd						NVARCHAR(10)
	,	size_cd							NVARCHAR(10)
	,	supplier_cd						INT
	)

	-- insert temp tables
	INSERT INTO #TMP_PRODUCT_COST_DELETE
	SELECT
		ISNULL(item_cd, '')
	,   ISNULL(color_cd, '')
	,   ISNULL(size_cd,'')
	,   ISNULL(supplier_cd,'')
	FROM OPENJSON (@P_costs)
	WITH (
		item_cd								NVARCHAR(30)
	,   color_cd							NVARCHAR(10)
	,   size_cd								NVARCHAR(10)
	,   supplier_cd							INT
	) AS TMP

	-- START TRANSACTION 
	BEGIN TRANSACTION
	-- TRY CATCH EXCEPTION
	BEGIN TRY
		
		UPDATE M202 SET
                    del_user_cd			= @P_act_user_cd
                  ,	del_prg				= @P_prg
                  ,	del_ip				= @P_ip
                  ,	del_tm				= @w_time
                  ,	del_flg				= 1
        FROM M202
        INNER JOIN #TMP_PRODUCT_COST_DELETE ON (
            M202.item_cd				= #TMP_PRODUCT_COST_DELETE.item_cd
		AND	M202.color_cd				= #TMP_PRODUCT_COST_DELETE.color_cd
		AND	M202.size_cd				= #TMP_PRODUCT_COST_DELETE.size_cd
        AND M202.supplier_cd			= #TMP_PRODUCT_COST_DELETE.supplier_cd
        )

	END TRY
	BEGIN CATCH
		SET @w_prs_result	=	'NG'
		SET @w_remarks		=	N'Error'                                                           + CHAR(13) + CHAR(10) +
								N'Procedure : ' + ISNULL(ERROR_PROCEDURE(), N'???')                + CHAR(13) + CHAR(10) +
								N'Line : '      + ISNULL(CAST(ERROR_LINE() AS NVARCHAR(10)), N'0') + CHAR(13) + CHAR(10) +
								N'Message : '   + ISNULL(ERROR_MESSAGE(), N'An unexpected error occurred.')
        DELETE FROM @ERR_TBL
        INSERT INTO @ERR_TBL
        SELECT  
            N'E009'
        ,   N''
        ,   0
        ,   999
        ,   0
		,	N''
        ,   @w_remarks
	END CATCH
    IF EXISTS (SELECT 1 FROM @ERR_TBL)
	BEGIN
		IF(@@TRANCOUNT > 0)
        BEGIN
            ROLLBACK TRANSACTION
        END
	END
	ELSE
	BEGIN
		DELETE FROM @ERR_TBL
		IF(@@TRANCOUNT > 0)
        BEGIN
            COMMIT TRANSACTION
        END
	END
    -- Insert statements for procedure here
	COMPLETE_QUERY:

	EXEC SPC_S999_ACT1
		@P_act_user_cd
	,	@P_prg
	,	@w_prs_mode
	,	@w_table_key
	,	@w_prs_result
	,	@w_remarks

	SELECT * FROM @ERR_TBL

	DROP TABLE IF EXISTS #TMP_PRODUCT_COST_DELETE
END
